<?php

namespace App\Http\Resources\Api\Movil;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
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
            'brand' => $this->brand->name,
            'sku' => $this->sku,
            'name' => $this->name,
            'model' => $this->model,
            'description' => $this->description,
            'variants' => VariantShowResource::collection($this->variants),
        ];
    }
}
