<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Media;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $path = 'images/products/';
    public function index()
    {
        $products = Product::with(['category', 'brand', 'media'])->get();

       return view('super-admin.pages.products.list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $medias = Media::all();
        return view('super-admin.pages.products.create', compact('categories', 'brands', 'medias'));
    }

    public function store(ProductRequest $request)
    {
        $image = MediaController::store(
            $request->image,
            $this->path,
            'image'
        );
        Product::create([
            'product_code' => $request->product_code,
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'stock' => $request->stock,
            'image' => $image->id
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $medias = Media::all();
        return view('products.edit', compact('product', 'categories', 'brands', 'medias'));
    }

    public function update(Request $request, Product $product)
    {
        $image = MediaController::update(
            $request->image,
            $this->path,
            'image'
        );
        $request->validate([
            'product_code' => "required|unique:products,product_code,{$product->id}",
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'stock' => 'required|integer',
            'image' => 'required',
        ]);

        $product->update([
            'product_code' => $request->product_code,
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'stock' => $request->stock,
            'image' => $image->id
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
