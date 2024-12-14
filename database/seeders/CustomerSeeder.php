<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Customer::create([
            'user_id' => $user->id,
            'sale_id' => null,
            'Total_Sales' => 100.00,
            'refer_code' => 'REF001',
            'refer_by' => null,
            'Total_sale_commission' => 20.00,
            'wallet_balance' => 50.00,
        ]);

        Customer::create([
            'user_id' => 2,
            'sale_id' => null,
            'Total_Sales' => 100.00,
            'refer_code' => 'REF002',
            'refer_by' => 'REF001',
            'Total_sale_commission' => 20.00,
            'wallet_balance' => 50.00,
        ]);

        Customer::create([
            'user_id' => 3,
            'sale_id' => null,
            'Total_Sales' => 100.00,
            'refer_code' => 'REF003',
            'refer_by' => 'REF002',
            'Total_sale_commission' => 20.00,
            'wallet_balance' => 50.00,
        ]);

        Customer::create([
            'user_id' => 4,
            'sale_id' => null,
            'Total_Sales' => 100.00,
            'refer_code' => 'REF004',
            'refer_by' => 'REF003',
            'Total_sale_commission' => 20.00,
            'wallet_balance' => 50.00,
        ]);

        // Add more customers as needed
    }
}
