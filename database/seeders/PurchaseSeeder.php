<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        // Fetch the first User and Product records
        $user = User::first();
        $product = Product::first();

        if ($user && $product) {
            // Create a Purchase record if both User and Product exist
            Purchase::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'commission' => 10.00,
            ]);
        } else {
            // Log or handle the case where User or Product is not found
            $this->command->info("User or Product not found.");
        }
    }
}
