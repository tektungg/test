<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'product_id'   => $this->product_id,
            'product_name' => $this->whenLoaded('product', fn () => $this->product->name),
            'qty'          => $this->qty,
            'total_price'  => 'Rp ' . number_format($this->total_price, 0, ',', '.'),
            'status'       => $this->status,
            'created_at'   => $this->created_at?->toDateTimeString(),
        ];
    }
}
