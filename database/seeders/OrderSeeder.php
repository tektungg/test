<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name'  => 'Demo Buyer',
            'email' => 'buyer@example.com',
        ]);

        $products = Product::where('is_active', 1)->get()->keyBy('id');

        $orders = [
            [1,  2, 'completed', 5],
            [2,  3, 'completed', 4],
            [3,  1, 'completed', 3],
            [5,  4, 'completed', 4],
            [6,  6, 'completed', 2],
            [7,  3, 'completed', 1],
            [8,  5, 'completed', 0],
            [9,  2, 'pending',   0],
            [11, 4, 'completed', 0],
            [12, 1, 'pending',   0],
            [13, 2, 'completed', 0],
            [14, 1, 'completed', 0],
            [15, 1, 'pending',   0],
            [1,  1, 'pending',   0],
            [2,  2, 'completed', 0],
        ];

        foreach ($orders as [$productId, $qty, $status, $daysAgo]) {
            $product = $products->get($productId);
            if (! $product) {
                continue;
            }

            Order::create([
                'user_id'     => $user->id,
                'product_id'  => $productId,
                'qty'         => $qty,
                'total_price' => $product->price * $qty,
                'status'      => $status,
                'created_at'  => now()->subDays($daysAgo),
                'updated_at'  => now()->subDays($daysAgo),
            ]);
        }
    }
}
