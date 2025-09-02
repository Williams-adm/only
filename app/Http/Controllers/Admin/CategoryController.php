<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Repositories\Admin\BaseRepository;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends BaseAdminController implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:manage categories'),
        ];
    }

    public function __construct()
    {
        $model = new Category();
        $viewName = 'categories';

        $repository = new BaseRepository($model, $viewName);

        $repository->setRelationChecker(function ($category) {
            return $category->subCategories()->count() > 0;
        });

        parent::__construct($repository);
    }
}
