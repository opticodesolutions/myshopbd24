<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MediaController extends Controller
{
    public function index()
    {
        $medias = Media::all();
        return response()->json($medias);

       // return view('medias.index', compact('medias'));
    }

    public function create()
    {
        return view('medias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'src' => 'required',
            'path' => 'required',
            'type' => 'required',
        ]);

        Media::create($request->all());

        return redirect()->route('medias.index')->with('success', 'Media created successfully.');
    }

    public function show(Media $media)
    {
        return view('medias.show', compact('media'));
    }

    public function edit(Media $media)
    {
        return view('medias.edit', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'src' => 'required',
            'path' => 'required',
            'type' => 'required',
        ]);

        $media->update($request->all());

        return redirect()->route('medias.index')->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $media)
    {
        $media->delete();

        return redirect()->route('medias.index')->with('success', 'Media deleted successfully.');
    }
}
