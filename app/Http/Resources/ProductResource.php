<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'properties' => $this->properties->map(function ($property) {
                return [
                    'name' => $property->name,
                    'value' => $property->pivot->value,
                ];
            }),
        ];
    }
}
