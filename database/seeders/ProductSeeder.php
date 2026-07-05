<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Makanan
            ['category' => 'Makanan', 'name' => 'Indomie Goreng', 'sku' => 'MKN-001', 'barcode' => '8996001600015', 'price' => 3500, 'stock' => 100],
            ['category' => 'Makanan', 'name' => 'Nasi Goreng Bungkus', 'sku' => 'MKN-002', 'barcode' => '8996001600022', 'price' => 15000, 'stock' => 50],
            ['category' => 'Makanan', 'name' => 'Roti Tawar Sari Roti', 'sku' => 'MKN-003', 'barcode' => '8996001600039', 'price' => 16000, 'stock' => 30],

            // Minuman
            ['category' => 'Minuman', 'name' => 'Aqua 600ml', 'sku' => 'MNM-001', 'barcode' => '8886008101053', 'price' => 4000, 'stock' => 200],
            ['category' => 'Minuman', 'name' => 'Teh Botol Sosro 450ml', 'sku' => 'MNM-002', 'barcode' => '8886008101060', 'price' => 5000, 'stock' => 150],
            ['category' => 'Minuman', 'name' => 'Kopi Kapal Api Sachet', 'sku' => 'MNM-003', 'barcode' => '8886008101077', 'price' => 2500, 'stock' => 300],

            // Snack
            ['category' => 'Snack', 'name' => 'Chitato Original 68g', 'sku' => 'SNK-001', 'barcode' => '8886008102001', 'price' => 10000, 'stock' => 80],
            ['category' => 'Snack', 'name' => 'Oreo Original', 'sku' => 'SNK-002', 'barcode' => '8886008102018', 'price' => 8500, 'stock' => 60],

            // Kebutuhan Rumah
            ['category' => 'Kebutuhan Rumah', 'name' => 'Sabun Lifebuoy 100g', 'sku' => 'KBR-001', 'barcode' => '8886008103001', 'price' => 5500, 'stock' => 120],
            ['category' => 'Kebutuhan Rumah', 'name' => 'Rinso Deterjen 800g', 'sku' => 'KBR-002', 'barcode' => '8886008103018', 'price' => 18000, 'stock' => 45],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->first();

            if ($category) {
                Product::updateOrCreate(
                    ['sku' => $item['sku']],
                    [
                        'category_id' => $category->id,
                        'name' => $item['name'],
                        'barcode' => $item['barcode'],
                        'price' => $item['price'],
                        'stock' => $item['stock'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
