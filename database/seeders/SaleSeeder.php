<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $product = Product::first();

        if ($user && $product) {
            Sale::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'commission' => 10.00,
            ]);
        } else {
            // Log or handle the case where User or Product is not found
            echo "User or Product not found.";
        }

        // Add more sales as needed
    }
}
