<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public $path = 'categories';
    public function index()
    {
        $categories = Category::with('user')->get();
        return view('super-admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('super-admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $slug = Str::slug($request->name);

        if ($request->hasFile('media')) {
            $image = MediaController::store(
                $request->file('media'),
                $this->path,
                'Image'
            );

        }
        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'media_id' => $image->id,
            'is_active' => $request->is_active == 'on' ? true : false,
            'create_by' => auth()->id(),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    public function show(Category $category)
    {
        return view('super-admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('super-admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $slug = Str::slug($request->input('name'));

        $data = $request->except('media');
        $data['slug'] = $slug;
        $data['is_active'] = $request->has('is_active') == 'on' ? true : false;

        if ($request->hasFile('media')) {
            if ($category->media_id) {
                $media = Media::find($category->media_id);
                MediaController::update($request->file('media'), $media, 'categories');
            } else {
                $media = MediaController::store($request->file('media'), 'categories');
                $data['media_id'] = $media->id;
            }
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }




    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
