<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatus;
use App\Enums\ShipmentStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\ShippingCompany;
use App\Traits\Admin\sweetAlerts;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class OrderTable extends DataTableComponent
{
    use sweetAlerts;

    protected $model = Order::class;

    public $couriers;

    public $newShipment = [
        'openModal' => false,
        'order_id' => '',
        'shipping_companies_id' => '',
        'tracking_number' => '',
    ];

    public function mount()
    {
        $this->couriers = ShippingCompany::all();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("N° orden", "id")
                ->sortable(),
            Column::make("Ticket")
                ->label(function ($row) {
                    return view('admin.orders.ticket', ['order' => $row]);
                }),
            Column::make("F. Orden", "created_at")
                ->format(function($value){
                    return $value->format('d/m/Y');
                })
                ->sortable(),
            Column::make("N° Productos", "content")
                ->format(function($value){
                    return count($value);
                })
                ->sortable(),
            Column::make("Total")
                ->format(function($value){
                    return "S/. " . number_format($value, 2);
                })
                ->sortable(),
            Column::make("Estado", "status")
                ->format(function($value){
                    return $value->name;
                })
                ->sortable(),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.orders.actions', ['order' => $row]);
                })
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Estado')
            ->options([
                '' => 'todos',
                1 => 'Pendiente',
                2 => 'Alistando',
                3 => 'Enviando',
                4 => 'Recibido',
                5 => 'Fallido',
                6 => 'Devuelto',
                7 => 'Cancelado',
            ])->filter(function ($query, $value) {
                $query->where('status', $value);
            })
        ];
    }

    public function downloadTicket(Order $order){
        return Storage::download($order->pdf_path);
    }

    public function markAsProcessing(Order $order){
        $order->status = OrderStatus::Alistando;
        $order->save();
    }

    public function assignShippingCompany(Order $order)
    {
        $this->newShipment['order_id'] = $order->id;
        $this->newShipment['openModal'] = true;
    }

    public function markAsRefunded(Order $order)
    {
        $order->status = OrderStatus::Devuelto;
        $order->save();

        $shipment = $order->shipments->last();
        $shipment->refunded_at = now();
        $shipment->save();
    }

    public function cancelOrder(Order $order)
    {
        if($order->status == OrderStatus::Pendiente || $order->status == OrderStatus::Alistando){
            $order->status = OrderStatus::Cancelado;
            $order->save();
            return;
        }

        if($order->status == OrderStatus::Enviando && $order->shipments->last()->status == ShipmentStatus::Pendiente){
            $order->status = OrderStatus::Cancelado;
            $order->save();

            $shipment = $order->shipments->last();
            $shipment->status = ShipmentStatus::Fallido;
            $shipment->save();
            return;
        }

        if($order->shipments->last()->status == ShipmentStatus::Enviando){
            $this->alertGenerate2([
                'icon' => 'error',
                'title' => '¡No se puede cancelar la orden!',
                'text' => "La orden se encuentra en camino",
            ]);

            return;
        }
        
        if($order->status == OrderStatus::Fallido){
            $this->alertGenerate2([
                'icon' => 'error',
                'title' => '¡No se puede cancelar la orden!',
                'text' => "La orden debe marcarse como devuelta",
            ]);

            return;
        }

        $order->status = OrderStatus::Cancelado;
        $order->save();
    }

    public function saveCourier()
    {
        $this->validateData();

        $order = Order::findOrFail($this->newShipment['order_id']);
        $order->status = OrderStatus::Enviando;
        $order->save();

        $order->shipments()->create([
            'shipping_companies_id' => $this->newShipment['shipping_companies_id'],
            'tracking_number' => $this->newShipment['tracking_number'],
        ]);

        $this->reset('newShipment');

    }

    public function validateData()
    {
        $this->validate(
            [
                'newShipment.shipping_companies_id' => 'required|exists:shipping_companies,id',
                'newShipment.tracking_number' => 'required|string|between:10,18|unique:shipments,tracking_number',
            ], [],
            [
                'newShipment.shipping_companies_id' => 'nombre del courier',
                'newShipment.tracking_number' => 'número de seguimiento',
            ]
        );
    }

    public function customView(): string
    {
        return 'admin.orders.modal';
    }
}
