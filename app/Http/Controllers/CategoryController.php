<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('user')->get();
        return view('super-admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('super-admin.pages.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'create_by' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('super-admin.pages.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('super-admin.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'create_by' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
