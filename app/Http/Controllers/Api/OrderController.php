<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->qty) {
            return response()->json([
                'message' => 'Stok produk tidak mencukupi.',
                'errors'  => [
                    'qty' => [
                        "Stok tersedia hanya {$product->stock}, sedangkan permintaan {$request->qty}.",
                    ],
                ],
            ], 422);
        }

        $order = DB::transaction(function () use ($request, $product) {
            $order = Order::create([
                'user_id'     => $request->user_id,
                'product_id'  => $product->id,
                'qty'         => $request->qty,
                'total_price' => $product->price * $request->qty,
                'status'      => 'pending',
            ]);

            $product->decrement('stock', $request->qty);

            return $order;
        });

        $order->load('product');

        return response()->json([
            'message' => 'Order berhasil dibuat.',
            'data'    => new OrderResource($order),
        ], 201);
    }
}
