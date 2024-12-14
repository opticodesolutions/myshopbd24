<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\SaleSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\MediaSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\PurchaseSeeder;
use Database\Seeders\RoleTableSeeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\CommissionSeeder;
use Database\Seeders\TransactionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleTableSeeder::class,
            UserTableSeeder::class,
            MediaSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            CommissionSeeder::class,
            SaleSeeder::class,
            CustomerSeeder::class,
            TransactionSeeder::class,
            PurchaseSeeder::class
        ]);
    }
}
