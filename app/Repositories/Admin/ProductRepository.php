<?php

namespace App\Repositories\Admin;

use App\Models\Product;
use App\Traits\Admin\sweetAlerts;

class ProductRepository extends BaseRepository
{
    use sweetAlerts;

    public function __construct(Product $model)
    {
        parent::__construct($model, 'products');
    }

    public function destroy(int $id)
    {
        /* Recordar regresarlo al normal ya que el delete es similar a otros */
        $product = Product::findOrFail($id);
        $product->delete();
        $this->alertGenerate1([
            'title' => '¡Registro eliminado!',
            'text' => "El registro ha sido eliminado correctamente",
        ]);
    }
}
