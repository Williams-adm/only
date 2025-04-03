<?php

namespace App\Repositories\Admin;

use App\Traits\Admin\sweetAlerts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VariantRepository
{
    use sweetAlerts;

    public function update($request, $variant)
    {
        DB::beginTransaction();
        try {

            if ($request->image) {
                $image = $variant->images->first();

                if ($image && $image->path) {

                    Storage::delete($variant->images->first()->path);
                    $img = $request->image->store('variants');

                    $variant->images()->update([
                        'path' => $img
                    ]);
                }
            }

            $variant->update([
                'stock' => $request->stock,
                'price' => $request->price
            ]);

            DB::commit();

            $this->alertGenerate1([
                'title' => '¡Variante actualizada!',
                'text' => 'La variante ha sido actualizada correctamente.',
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            $this->alertGenerate1([
                'title' => "¡Error!",
                'text' => "Hubo un problema al actualizar la variante.",
                'icon' => "error",
            ]);
        }
    }
}