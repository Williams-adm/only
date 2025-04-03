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

                // Si ya existe una imagen, la eliminamos
                if ($image && $image->path) {
                    Storage::delete($image->path);
                }

                // Almacenamos la nueva imagen
                $img = $request->image->store('variants');

                // Si ya existe una imagen, actualizamos el path de esa imagen
                if ($image) {
                    $image->update([
                        'path' => $img
                    ]);
                } else {
                    // Si no existe ninguna imagen, creamos una nueva entrada en la relación
                    $variant->images()->create([
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