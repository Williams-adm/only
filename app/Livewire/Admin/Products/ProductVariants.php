<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use App\Models\Option;
use App\Traits\Admin\generateCombinations;
use App\Traits\Admin\sweetAlerts;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductVariants extends Component
{
    use sweetAlerts;
    use generateCombinations;

    public $product;

    public $openModal = false;

    public $variant = [
        'option_id' => '',
        'features' => [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ]
        ],
    ];

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

    public function updatedVariantOptionId()
    {
        foreach ($this->variant['features'] as &$feature) {
            $feature['id'] = '';
            $feature['value'] = '';
            $feature['description'] = '';
        }
    }

    #[Computed()]
    public function options() 
    {
        return Option::whereDoesntHave('products', function ($query){
            $query->where('product_id', $this->product->id);
        })->get();
    }

    #[Computed()]
    public function features()
    {
        return Feature::where('option_id', $this->variant['option_id'])->get();
    }

    public function addFeature()
    {
        $this->variant['features'][] = [
            'id' => '',
            'value' => '',
            'description' => '',
        ];
    }

    public function featureChange($index)
    {
        $idFeature = $this->variant['features'][$index]['id'];

        $feature = Feature::findOrFail($idFeature);

        if($feature){
            $this->variant['features'][$index]['value'] = $feature->value;
            $this->variant['features'][$index]['description'] = $feature->description;
        }
    }

    public function save()
    {
        $this->validateData();

        $this->product->options()->attach( $this->variant['option_id'], [
            'features' => $this->variant['features'],
        ]);

        $this->alertGenerate2();

        $this->product = $this->product->fresh();

        $this->reset(['variant', 'openModal']);
    }

    public function validateData()
    {
        $rules = [
            'variant.option_id' => [
                'required',
                'exists:options,id',
                Rule::unique('option_product', 'option_id')->where(fn(Builder $query) => $query->where('product_id', $this->product->id))
            ],
            'variant.features.*.id' => 'required|exists:features,id',
        ];

        // Mensajes personalizados
        $validationMessages = [];

        // Atributos personalizados
        $validationAttributes = [
            'variant.option_id' => 'opción',
        ];

        foreach ($this->variant['features'] as $index => $feature) {
            $rules['variant.features.' . $index . '.id'] = [
                'required',
                'exists:features,id',
                'distinct:strict'
            ];

            $validationMessages['variant.features.' . $index . '.id.required'] = "El valor del campo " . ($index + 1) . ", es obligatorio";
            $validationMessages['variant.features.' . $index . '.id.distinct'] = "El valor del campo " . ($index + 1) . ", continene un valor duplicado";
        }

        $this->validate($rules, $validationMessages, $validationAttributes);
    }

    /**
     * Elimina del modal los features
     */
    public function removeFeature($index)
    {
        unset($this->variant['features'][$index]);
        $this->variant['features'] = array_values($this->variant['features']);
    }

    /**
     * Elimina de la vista los features
     */
    public function deleteFeature($feature_id, $option_id)
    {
        $features = $this->product->options()->findOrFail($option_id)->pivot->features;

        // Filtramos el feature que se quiere eliminar
        $filteredFeatures = array_filter($features, function ($feature) use ($feature_id) {
            return $feature['id'] != $feature_id;
        });

        // Reindexamos el array para que tenga índices consecutivos
        $filteredFeatures = array_values($filteredFeatures);

        // Actualizamos la base de datos con el array limpio y reindexado
        $this->product->options()->updateExistingPivot($option_id, [
            'features' => $filteredFeatures
        ]);

        $this->product = $this->product->fresh();
    }

    public function deleteOption($option_id)
    {
        $this->product->options()->detach($option_id);
        $this->product = $this->product->fresh();
    }

    /**
     * Actualizar en la vista la nueva variant agregada por product-add-new-variant
     */
    #[On('variantOptionProductAdd')]
    public function updateFeatureOptionList()
    {
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}
