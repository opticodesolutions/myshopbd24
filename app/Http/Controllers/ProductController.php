<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    private $path = 'images/products/';
    public function index()
    {
        $products = Product::with(['category', 'brand'])->get();

        return view('super-admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $medias = Media::all();
        return view('super-admin.products.create', compact('categories', 'brands', 'medias'));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'product_code' => $request->product_code,
            'name' => $request->name,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'stock' => $request->stock,
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                $image = MediaController::store(
                    $imageFile,
                    $this->path,
                    'Image'
                );

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_id' => $image->id,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully with images.');
    }



    public function show(Product $product)
    {
        $product = $product->load(['category', 'brand', 'images.media', 'commissions', 'sales']);
        $categories = Category::all();
        return view('frontend.pages.products.show', compact('product', 'categories'));
    }



    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $medias = $product->images()->with('media')->get();
        return view('super-admin.products.edit', compact('product', 'categories', 'brands', 'medias'));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'brand_id' => 'required',
            'stock' => 'required|integer',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_images' => 'array',
        ]);

        $product->update([
            'product_code' => $validated['product_code'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'stock' => $validated['stock'],
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $image = MediaController::store($file, $this->path, 'image');

                $product->images()->create([
                    'media_id' => $image->id,
                ]);
            }
        }

        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $productImage = ProductImage::find($imageId);
                if ($productImage) {
                    Storage::disk('public')->delete($productImage->media->src);
                    $productImage->media->delete();
                    $productImage->delete();
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }




    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
