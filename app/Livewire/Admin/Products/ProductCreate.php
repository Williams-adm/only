<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\SubCategory;
use App\Traits\Admin\skuGenerator;
use App\Traits\Admin\sweetAlerts;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{
    use WithFileUploads;
    use skuGenerator;
    use sweetAlerts;

    public $families;

    public $family_id = '';
    public $stock = '';
    public $category_id = '';
    public $sub_category_id = '';
    public $name = '';
    public $price = '';
    public $description = '';
    public $image;

    public function mount()
    {
        $this->families = Family::all();
    }
    
    /**
     * el método boot se ejecuta cada vez que se renderiza la pag
     */
    public function boot()
    {
        $this->withValidator(function ($validator)
        {
            if($validator->fails()){
                $this->alertGenerate2([
                    'icon' => 'error',
                    'title' => '¡Error!',
                    'text' => "El formulario contiene errores",
                ]);
            }
        });
    }

    public function updatedFamilyId()
    {
        $this->reset('category_id');
        $this->reset('sub_category_id');
    }
    
    public function updatedCategoryId()
    {
        $this->reset('sub_category_id');
    }

    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->family_id)->get();
    }
    
    #[Computed()]
    public function subcategories()
    {
        return SubCategory::where('category_id', $this->category_id)->get();
    }

    public function save()
    {
        $this->validateData();

        $sku = $this->generateSku($this->sub_category_id, $this->name);
        
        DB::beginTransaction();
        try{
            $product = Product::create([
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'sku' => $sku,
                'description' => $this->description,
                'sub_category_id' => $this->sub_category_id,
            ]);
            
            $path = $this->image->store('products');
            $product->images()->create([
                'path' => $path
            ]);

            DB::commit();

            $this->alertGenerate1();
    
            return redirect()->route('admin.products.create');

        }catch (\Exception $e) {
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
        $this->validate(
            [
                'family_id' => 'required|exists:families,id',
                'category_id' => 'required|exists:categories,id',
                'sub_category_id' => 'required|exists:sub_categories,id',
                'name' => [
                    'required',
                    'string',
                    'regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
                    'between:3,80',
                    Rule::unique('products', 'name')->where(fn(Builder $query) => $query->where('sub_category_id', $this->sub_category_id))
                ],
                'price' => 'required|numeric|decimal:2|min:1',
                'stock' => 'required|min:1|integer',
                'description' => 'nullable|string',
                'image' => 'required|image|max:1024'
            ],
            [
                'name.regex' => 'El campo nombre solo puede contener letras y espacios.',
                'name.unique' => 'El nombre ya está relacionado con esta subcategoria.',
                'price.min' => 'El precio debe ser mayor a S/. 0.00'
            ],
            [
                'category_id' => 'categoría',
                'sub_category_id' => 'subcategoría',
            ]
        );
    }

    public function render()
    {
        return view('livewire.admin.products.product-create');
    }
}
