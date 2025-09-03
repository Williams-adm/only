<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Traits\Admin\skuGenerator;
use App\Traits\Admin\sweetAlerts;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{
    use WithFileUploads;
    use skuGenerator;
    use sweetAlerts;

    public $categories;
    public $brands;

    public $category_id = '';
    public $sub_category_id = '';
    public $brand_id = '';
    public $name = '';
    public $model = '';
    public $description = '';

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
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

    public function updatedCategoryId()
    {
        $this->reset('sub_category_id');
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

        $data = Product::create([
            'name' => $this->name,
            'model' => $this->model,
            'sku' => $sku,
            'description' => $this->description,
            'brand_id' => $this->brand_id,
            'sub_category_id' => $this->sub_category_id,
        ]);

        $this->alertGenerate1();

        return redirect()->route('admin.products.show', $data);
    }

    public function validateData()
    {
        $this->validate(
            [
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'sub_category_id' => 'required|exists:sub_categories,id',
                'name' => [
                    'required',
                    'string',
                    'between:3,80',
                    Rule::unique('products', 'name')->where(fn(Builder $query) => $query->where('sub_category_id', $this->sub_category_id))
                ],
                'model' => [
                    'required',
                    'string',
                    'between:3,80',
                ],
                'description' => 'required|string',
            ],
            [
                'name.regex' => 'El campo nombre solo puede contener letras y espacios.',
                'name.unique' => 'El nombre ya está relacionado con esta subcategoria.',
            ],
            [
                'model' => 'modelo',
                'category_id' => 'categoría',
                'brand_id' => 'marca',
                'sub_category_id' => 'subcategoría',
            ]
        );
    }

    public function render()
    {
        return view('livewire.admin.products.product-create');
    }
}
