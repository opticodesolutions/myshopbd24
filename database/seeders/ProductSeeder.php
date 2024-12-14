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
            'name' => 'Basic Membership',
            'price' => 6900,
            'discount_price' => 89.99,
            'purchase_commission' => 10,
            'description' => 'Basic membership product for MLM users.',
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'stock' => 50,
        ]);

        $products->images()->create([
            'image_id' => $mediaId,
        ]);
    }
}
