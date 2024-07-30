<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_code' => 1001,
            'name' => 'Product 1',
            'price' => 100.00,
            'discount_price' => 90.00,
            'description' => 'Description of Product 1',
            'category_id' => 1,
            'brand_id' => 1,
            'stock' => 10,
            'image' => 1,
        ]);
    }
}
