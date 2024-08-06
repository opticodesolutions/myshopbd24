<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'media'])->get();

       return view('super-admin.pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $medias = Media::all();
        return view('super-admin.pages.products.create', compact('categories', 'brands', 'medias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'stock' => 'required|integer',
            'image' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Fetch the related brands, categories, and media for the dropdowns
        $brands = Brand::all();
        $categories = Category::all();
        $medias = Media::all();


        return view('super-admin.pages.products.edit', compact('product', 'brands', 'categories', 'medias'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $product->id,
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'stock' => 'required|integer',
            'image' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
