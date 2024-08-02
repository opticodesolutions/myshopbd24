<?php

namespace Database\Seeders;

use App\Models\Commission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionSeeder extends Seeder
{
    public function run()
    {
        DB::table('commissions')->insert([
            [
                'product_id' => 1,
                'amount' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more commissions as needed
        ]);
    }
}
