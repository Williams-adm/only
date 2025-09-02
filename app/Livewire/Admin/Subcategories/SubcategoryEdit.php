<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Traits\Admin\sweetAlerts;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SubcategoryEdit extends Component
{
    use sweetAlerts;

    public $data;
    public $categories;
    public $category_id = '';
    public $name = '';

    protected $listeners = ['save' => 'save'];

    /**
     * Se ejectura ni bien se cargue el componente
     */
    public function mount($data)
    {
        $this->categories = Category::all();

        $this->category_id = $data->category_id;
        $this->name = $data->name;
    }

    public function save()
    {
        $this->validateData();

        $this->data->update([
            'category_id' => $this->category_id,
            'name'        => $this->name,
        ]);

        $this->dispatch('subcategoryUpdated', $this->name);

        $this->alertGenerate2([
            'title' => '¡Registro actualizado!',
            'text' => "El registro ha sido actualizado correctamente",
        ]);
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
                    Rule::unique('sub_categories', 'name')
                        ->where(fn($query) => $query->where('category_id', $this->category_id))
                        ->ignore($this->data->id)
                ],
            ],
            [
                'name.regex' => 'El campo nombre solo puede contener letras y espacios.',
                'name.unique' => 'El nombre ya está relacionado con esta categoria.'
            ],
            [
                'category_id' => 'categoria',
                'name' => 'nombre',
            ]
        );
    }

    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-edit');
    }
}
