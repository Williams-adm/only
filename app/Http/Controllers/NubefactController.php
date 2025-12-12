<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NubefactController extends Controller
{
    public function generarFactura($order_id)
    {
        $order = Order::findOrFail($order_id);

        $items = [];
        $total_igv = 0;
        $total_gravada = 0;
        $total = 0;

        foreach ($order->content as $item) {

            $precio_unitario = $item['price'];
            $valor_unitario = round($precio_unitario / 1.18, 2);

            $subtotal = round($valor_unitario * $item['qty'], 2);
            $igv = round(($precio_unitario - $valor_unitario) * $item['qty'], 2);
            $total_item = round($precio_unitario * $item['qty'], 2);

            // Acumular totales
            $total_igv += $igv;
            $total_gravada += $subtotal;
            $total += $total_item;

            $items[] = [
                "unidad_de_medida" => "NIU",
                "codigo" => $item['id'],
                "descripcion" => $item['name'],
                "cantidad" => $item['qty'],
                "valor_unitario" => $valor_unitario,
                "precio_unitario" => $precio_unitario,
                "subtotal" => $subtotal,
                "tipo_de_igv" => "1",
                "igv" => $igv,
                "total" => $total_item
            ];
        }

        $total_igv = round($total_igv, 2);
        $total_gravada = round($total_gravada, 2);
        $total = round($total, 2);

        $data = [
            "operacion" => "generar_comprobante",
            "tipo_de_comprobante" => "2",
            "serie" => "BBB1",
            "numero" => $order->id,
            "sunat_transaction"      => "1",
            "cliente_tipo_de_documento" => 1,
            "cliente_numero_de_documento" => 75235987,
            "cliente_denominacion" => "Anttec",
            "cliente_direccion" => "CALLE LIBERTAD 116 - Huancayo - PERU",

            "fecha_de_emision" => now()->format('Y-m-d'),
            "moneda" => "1",
            "porcentaje_de_igv" => "18",

            "total_gravada" => $total_gravada,
            "total_igv" => $total_igv,
            "total" => $total,
            "items" => $items,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Token token="' . env('NUBEFACT_TOKEN') . '"',
            'Content-Type' => 'application/json'
        ])->post(env('NUBEFACT_URL'), $data)->json();

        // Guardar datos de la factura
        $order->update([
            'xml' => $response['xml_zip_base64'] ?? null,
            'pdf' => $response['pdf_zip_base64'] ?? null,
            'cdr' => $response['cdr_zip_base64'] ?? null,
            'hash' => $response['codigo_hash'] ?? null,
        ]);

        return $response['enlace_del_pdf'] ?? null;
    }
}
