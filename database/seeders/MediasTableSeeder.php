<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Media::create([
            'src' => 'path/to/image1.jpg',
            'path' => 'uploads/images/image1.jpg',
            'type' => 'image/jpeg',
        ]);
    }
}
