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
        $categoryId = Category::first()->id;
        $brandId = Brand::first()->id;
        $mediaId = Media::first()->id;

       $products = Product::create([
            'product_code' => 1001,
            'name' => 'Product 1',
            'price' => 99.99,
            'discount_price' => 89.99,
            'perchase_commission' => 10,
            'description' => 'Description for Product 1',
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'stock' => 50,
        ]);

        $products->images()->create([
            'image_id' => $mediaId,
        ]);
    }
}
