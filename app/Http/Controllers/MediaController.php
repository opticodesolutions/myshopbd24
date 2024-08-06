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

    public static function update(?UploadedFile $file, string $path, string $type = null, ?Media $media = null): ?Media
    {
        if (!$file || !$media) {
            return $media; // Return the existing media if no file or media object is provided
        }

        // Delete the old image if it exists
        if (Storage::exists($media->src)) {
            Storage::delete($media->src);
        }

        // Store the new image
        $path = Storage::put('/' . trim($path, '/'), $file, 'public');
        $extension = $file->extension();
        if (!$type) {
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'image' : $extension;
        }

        $media->update([
            'type' => $type,
            'src' => $path,
            'path' => $path,
        ]);

        return $media;
    }



}
