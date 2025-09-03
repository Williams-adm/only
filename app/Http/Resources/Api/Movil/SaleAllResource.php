<?php

namespace App\Http\Resources\Api\Movil;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleAllResource extends JsonResource
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
            'time' => $this->date_transaction,
            'total' => $this->total,
        ];
    }
}
