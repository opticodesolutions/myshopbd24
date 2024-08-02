<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Media;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure that these IDs exist in the respective tables
        $categoryId = Category::first()->id; // Replace with actual ID or method to get an ID
        $brandId = Brand::first()->id;       // Replace with actual ID or method to get an ID
        $mediaId = Media::first()->id;       // Replace with actual ID or method to get an ID

        Product::create([
            'product_code' => 1001,
            'name' => 'Product 1',
            'price' => 99.99,
            'discount_price' => 89.99,
            'description' => 'Description for Product 1',
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'stock' => 50,
            'image' => $mediaId,
        ]);

        // Add more products as needed
    }
}
