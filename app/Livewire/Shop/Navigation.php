<?php

namespace App\Livewire\Shop;

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Navigation extends Component
{
    public $categories;

    public $category_id;

    public function mount()
    {
        $this->categories = Category::all();
        $this->category_id = $this->categories->first()->id;
    }

    #[Computed()]
    public function selectedCategory()
    {
        return Category::with('subCategories')->find($this->category_id);
    }
    
    #[Computed()]
    public function categoryName()
    {
        return Category::find($this->category_id)->name;
    }

    public function render()
    {
        return view('livewire.shop.navigation');
    }
}
