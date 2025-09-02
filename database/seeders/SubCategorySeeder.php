<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            'gamer',
            'oficina',
        ];

        $categories = Category::all()->pluck('id')->toArray();

        foreach ($categories as $category){
            foreach ($subcategories as $subcategory){
                SubCategory::create([
                    'name' => $subcategory,
                    'category_id' => $category
                ]);
            }
        }
    }
}
