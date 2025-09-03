<?php

namespace App\Http\Controllers\Api\Movil;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Movil\ProductResource;
use App\Http\Resources\Api\Movil\ProductShowResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAll(Request $filter)
    {
        $category = $filter->query('category');
        $category_id = Category::findOrFail($category)->id;

        $products = Product::when($category_id, function ($query, $category_id) {
            $query->whereHas('subCategory', function ($q) use ($category_id) {
                $q->where('category_id', $category_id);
            });
        })->get();

        return ProductResource::collection($products);
    }

    public function getById(Product $product)
    {
        if(!$product){
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return new ProductShowResource($product);
    }

    public function scanBarcode(string $code)
    {
        $verifiedProduct = Product::where('sku', $code)->first();

        if (!$verifiedProduct) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return new ProductShowResource($verifiedProduct);
    }
}
