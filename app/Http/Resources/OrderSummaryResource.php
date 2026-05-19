<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'user'         => $this->whenLoaded('user', fn () => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ]),
            'product'      => $this->whenLoaded('product', fn () => [
                'id'    => $this->product->id,
                'name'  => $this->product->name,
                'price' => 'Rp ' . number_format($this->product->price, 0, ',', '.'),
            ]),
            'qty'          => $this->qty,
            'total_price'  => 'Rp ' . number_format($this->total_price, 0, ',', '.'),
            'status'       => $this->status,
            'created_at'   => $this->created_at?->toDateTimeString(),
        ];
    }
}
