<?php

namespace App\Http\Resources\Api\Movil;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => asset('storage/' . $this->images->first()->path)
        ];
    }
}
