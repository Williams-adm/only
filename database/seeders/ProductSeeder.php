<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::deleteDirectory('products');

        Product::factory(10)->create();

        /* $products = Product::all();

        foreach($products as $product) {
            Image::factory()
                ->configureImage('products', "{$product->name}")
                ->create([
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                ]);
        } */
    }
}
