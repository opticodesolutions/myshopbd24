<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        Brand::create([
            'name' => 'Brand 1',
            'created_by' => 1,
        ]);
        // Add more brands as needed
    }
}
