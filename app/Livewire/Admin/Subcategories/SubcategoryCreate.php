<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\Admin\sweetAlerts;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SubcategoryCreate extends Component
{
    use sweetAlerts;

    public $categories;
    public $category_id = '';
    public $name = '';

    /**
     * Se ejectura ni bien se cargue el componente
     */
    public function mount()
    {
        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validateData();

        SubCategory::create([
            'category_id' => $this->category_id,
            'name'        => $this->name,
        ]);

        $this->alertGenerate1();

        return redirect()->route('admin.subcategories.create');
    }

    public function validateData()
    {
        $this->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'name' => [
                    'required',
                    'string',
                    'regex:/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/',
                    'between:3,60',
                    Rule::unique('sub_categories', 'name')->where(fn(Builder $query) => $query->where('category_id', $this->category_id))
                ],
            ],
            [
                'name.regex' => 'El campo nombre solo puede contener letras y espacios.',
                'name.unique' => 'El nombre ya está relacionado con esta categoria.'
            ],
            [
                'category_id' => 'categoría',
                'name' => 'nombre',
            ]
        );
    }

    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-create');
    }
}
