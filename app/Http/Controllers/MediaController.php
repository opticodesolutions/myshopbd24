<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{

    public static function store(UploadedFile $file, string $path, string $type = null): Media
    {
        $path = Storage::put('/' . trim($path, '/'), $file, 'public');
        $extension = $file->extension();
        if (!$type) {
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }

        return Media::create([
            'type' => $type,
            'src' => $path,
            'path' => $path,
        ]);
    }

    public static function update(UploadedFile $file, Media $media, string $path, string $type = null): Media
    {
        if ($media && Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }

        $newPath = Storage::put('/' . trim($path, '/'), $file, 'public');
        $extension = $file->extension();
        if (!$type) {
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }
        $media->update([
            'type' => $type,
            'src' => $newPath,
            'path' => $newPath,
        ]);

        return $media;
    }
}
