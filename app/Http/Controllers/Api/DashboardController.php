<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderSummaryResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const CACHE_KEY = 'dashboard_summary';
    private const CACHE_TTL = 300;

    public function summary(): JsonResponse
    {
        $fromCache = Cache::has(self::CACHE_KEY);

        $payload = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $stats = [
                'total_revenue'         => (float) Order::where('status', 'completed')->sum('total_price'),
                'total_orders_today'    => Order::whereDate('created_at', today())->count(),
                'total_products_active' => Product::where('is_active', 1)->count(),
                'low_stock_count'       => Product::where('stock', '<', 5)->count(),
            ];

            $topProducts = Order::query()
                ->select('product_id', DB::raw('SUM(qty) as total_sold'))
                ->where('status', 'completed')
                ->groupBy('product_id')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->with('product.category')
                ->get()
                ->map(fn ($row) => [
                    'product_id'   => $row->product_id,
                    'product_name' => $row->product?->name,
                    'category'     => $row->product?->category?->name,
                    'total_sold'   => (int) $row->total_sold,
                    'price'        => $row->product
                        ? 'Rp ' . number_format($row->product->price, 0, ',', '.')
                        : null,
                ]);

            $latestOrders = Order::with(['user', 'product'])
                ->latest()
                ->limit(10)
                ->get();

            return [
                'stats'         => $stats,
                'top_products'  => $topProducts,
                'latest_orders' => OrderSummaryResource::collection($latestOrders)->resolve(),
            ];
        });

        return response()->json([
            'from_cache' => $fromCache,
            'data'       => $payload,
        ]);
    }

    public function flushCache(): JsonResponse
    {
        Cache::forget(self::CACHE_KEY);

        return response()->json([
            'message' => 'Cache dashboard berhasil dihapus.',
        ]);
    }
}
