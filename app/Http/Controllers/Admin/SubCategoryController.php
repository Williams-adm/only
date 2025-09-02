<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use App\Repositories\Admin\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubCategoryController extends BaseAdminController implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:manage subcategories'),
        ];
    }

    public function __construct()
    {
        $model = new SubCategory();
        $viewName = 'subcategories';
        $relationships = [
            'category',
        ];

        $repository = new BaseRepository($model, $viewName, $relationships);

        $repository->setRelationChecker(function ($subcategory) {
            return $subcategory->products()->count() > 0;
        });

        parent::__construct($repository);
    }
}
