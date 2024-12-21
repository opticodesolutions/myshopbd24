<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->insert([
            [
                'name' => 'Brand 1',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more brands as needed
        ]);
    }
}
