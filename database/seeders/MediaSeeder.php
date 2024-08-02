<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        Media::create([
            'src' => 'path/to/media1.jpg',
            'path' => 'media1.jpg',
            'type' => 'image/jpeg',
        ]);

        // Add more media as needed
    }
}
