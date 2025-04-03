<?php

namespace App\Livewire\Admin\Products\Variants;

use App\Models\OptionProduct;
use App\Models\Variant;
use App\Rules\Admin\UniqueVariantFeature;
use App\Traits\Admin\skuGenerator;
use App\Traits\Admin\sweetAlerts;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class VariantCreate extends Component
{
    use WithFileUploads;
    use skuGenerator;
    use sweetAlerts;

    public $product; 

    public $options;

    public $image;

    public $variants = [
        [
            'option_id' => '',
            'id' => '',
        ]
    ];

    public $infoVariant = [
        'stock',
        'price'
    ];

    public function mount()
    {
        $this->options = $this->product->options;
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->alertGenerate2([
                    'icon' => 'error',
                    'title' => '¡Error!',
                    'text' => "El formulario contiene errores",
                ]);
            }
        });
    }
    
    #[Computed()]
    public function variantFeatures($index)
    {
        $option_id = $this->variants[$index]['option_id'];

        return OptionProduct::where('product_id', $this->product->id)
            ->where('option_id', $option_id)
            ->get();
    }

    /**
     * Para resetear el feature cuando se cambia de opcion
     */
    public function resetFeatures($index)
    {
        $this->variants[$index]['id'] = '';
    }

    public function addFeature()
    {
        $this->variants[] = [
            'option_id' => '',
            'id' => '',
        ];
    }

    public function removeFeature($index)
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function save()
    {
        $this->validateData();

        $sku = $this->generateSkuVariant($this->product->name);

        DB::beginTransaction();
        try{
            $variant = Variant::create([
                'stock' => $this->infoVariant['stock'],
                'price' => $this->infoVariant['price'],
                'sku' => $sku,
                'product_id' => $this->product->id,
            ]);
            
            $path = $this->image->store('variants');
            $variant->images()->create([
                'path' => $path
            ]);
    
            foreach ($this->variants as $index => $features) {
                $variant->features()->attach($features['id']);
            }

            DB::commit();

            $this->alertGenerate2([
                'title' => 'Variante creada',
                'text' => 'La variante ha sido creado correctamente.',
            ]);
    
            $this->reset(['variants', 'image', 'infoVariant']);
            
        }catch(\Exception $e){
            DB::rollback();

            $this->alertGenerate1([
                'title' => "¡Error!",
                'text' => "Hubo un problema al crear el registro.",
                'icon' => "error",
            ]);
        }
    }

    public function validateData()
    {
        $rules = [
            'image' => 'required|image|max:1024',
            'infoVariant.stock' => 'required|min:1|integer',
            'infoVariant.price' => 'required|numeric|decimal:2|min:1',
            'variants.*.option_id' => 'required|distinct:strict',
            'variants.*.id' => ['required', new UniqueVariantFeature($this->product->id, $this->variants)],
        ];

        $validationMessages = [
            'infoVariant.price.min' => 'El precio debe ser mayor a S/. 0.00'
        ];

        $validationAttributes = [
            'infoVariant.stock' => 'stock',
            'infoVariant.price' => 'precio',
        ];

        foreach ($this->variants as $index => $fetureVariant){
            $validationMessages['variants.' . $index . '.option_id.required'] = "La opción del campo " . ($index + 1) . ", es obligatorio";
            $validationMessages['variants.' . $index . '.id.required'] = "El valor del campo " . ($index + 1) . ", es obligatorio";
            $validationMessages['variants.' . $index . '.option_id.distinct'] = "La opción del campo " . ($index + 1) . ", se encuentra duplicado";
        }


        $this->validate($rules, $validationMessages, $validationAttributes);
    }

    public function render()
    {
        return view('livewire.admin.products.variants.variant-create');
    }
}
