<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            'Elektronik',
            'Makanan & Minuman',
            'Pakaian',
            'Aksesoris',
        ];

        $categories = collect($categoriesData)->map(fn ($name) => Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]));

        $products = [
            ['Laptop Asus ROG',          0, 18500000, 5,  true],
            ['Mouse Logitech G502',      0, 850000,   25, true],
            ['Keyboard Mechanical RGB',  0, 1250000,  12, true],
            ['Monitor LG 27 inch',       0, 4200000,  0,  false],
            ['Kopi Arabica 250gr',       1, 95000,    50, true],
            ['Teh Premium Box',          1, 65000,    40, true],
            ['Indomie Goreng 1 Dus',     1, 110000,   100, true],
            ['Kaos Polos Cotton',        2, 75000,    30, true],
            ['Jaket Hoodie Fleece',      2, 250000,   15, true],
            ['Celana Jeans Slim Fit',    2, 295000,   8,  false],
            ['Topi Baseball',            3, 85000,    20, true],
            ['Tas Ransel Eiger',         3, 450000,   10, true],
            ['Dompet Kulit',             3, 175000,   18, true],
            ['Smartwatch Fitness',       0, 1500000,  7,  true],
            ['Headphone Bluetooth',      0, 650000,   22, true],
        ];

        foreach ($products as [$name, $catIdx, $price, $stock, $active]) {
            Product::create([
                'name'        => $name,
                'category_id' => $categories[$catIdx]->id,
                'price'       => $price,
                'stock'       => $stock,
                'is_active'   => $active,
            ]);
        }
    }
}
