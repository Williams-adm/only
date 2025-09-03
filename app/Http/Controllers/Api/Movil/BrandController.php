<?php

namespace App\Http\Controllers\Api\Movil;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Movil\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function getAll()
    {
        return BrandResource::collection((Brand::all()));
    }
}
