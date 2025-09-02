<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Repositories\Admin\BaseRepository;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BrandController extends BaseAdminController implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:manage brands'),
        ];
    }

    public function __construct()
    {
        $model =  new Brand();
        $viewName = 'brands';

        $repository = new BaseRepository($model, $viewName);

        $repository->setRelationChecker(function ($brand) {
            return $brand->products()->count() > 0;
        });

        parent::__construct($repository);
    }
}
