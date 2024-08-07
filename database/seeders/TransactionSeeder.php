<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Sale;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $sale = Sale::first();

        if ($user && $sale) {
            Transaction::create([
                'user_id' => $user->id,
                'sale_id' => $sale->id,
                'amount' => 100.00,
                'transaction_type' => 'sale',
            ]);
        } else {
            // Log or handle the case where User or Sale is not found
            echo "User or Sale not found.";
        }

        // Add more transactions as needed
    }
}
