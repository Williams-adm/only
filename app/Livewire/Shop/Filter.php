<?php

namespace App\Livewire\Shop;

use App\Models\Option;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Filter extends Component
{
    use WithPagination;

    public $family_id;
    public $category_id;
    public $subcategory_id;

    public $options;
    public $select_features = [];
    public $orderBy = 1;
    public $search;

    public function mount()
    {
        $this->options = Option::verifyCategory($this->category_id)
        ->verifySubCategory($this->subcategory_id)
        ->get()->toArray();
    }

    #[On('search')]
    public function search($search)
    {
        $this->search = $search;
    }

    public function render()
    {
        $products = Product::verifyCategory($this->category_id)
        ->verifySubCategory($this->subcategory_id)
        ->customOrder($this->orderBy)
        ->selectFeatures($this->select_features)
        ->search($this->search)
        ->paginate(12);

        return view('livewire.shop.filter', compact('products'));
    }
}
