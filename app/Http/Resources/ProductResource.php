<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'category_name' => $this->whenLoaded('category', fn () => $this->category->name),
            'price'         => 'Rp ' . number_format($this->price, 0, ',', '.'),
            'stock'         => $this->stock,
            'is_active'     => (bool) $this->is_active,
        ];
    }
}
