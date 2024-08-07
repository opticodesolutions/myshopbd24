<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    private $path = 'images/products/';
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

    public function store(ProductRequest $request)
    {
        try {
            // Ensure the image is present and valid
            if ($request->hasFile('image')) {
                // Store the image and get the Media object
                $image = MediaController::store(
                    $request->file('image'), // Get the UploadedFile instance
                    'images/products', // Path to store the image
                    'image'
                );
            } else {
                // Handle the case where no image is provided if necessary
                $image = null;
            }

            // Create the new product
            Product::create([
                'product_code' => $request->product_code,
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'stock' => $request->stock,
                'image' => $image ? $image->id : null // Use image ID if available
            ]);

            // Redirect with success message
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error("Failed to create product: " . $e->getMessage());

            // Redirect back to the create page with an error message
            return redirect()->route('products.create')->with('error', $e->getMessage());
        }
    }


    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'media','commissions'])->find($id);
        //return json_encode($product);
        return view('super-admin.pages.products.show', compact('product'));
    }

    public function edit(Product $id)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $medias = Media::all();
        return view('super-admin.pages.products.edit', compact('product', 'categories', 'brands', 'medias'));
    }

    public function update(ProductRequest $request, Product $product)
{
    $validated = $request->validated();

    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($product->image) {
            $oldImage = Media::find($product->image);
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->src);
                $oldImage->delete();
            }
        }

        // Store new image
        $file = $request->file('image');
        $image = Media::store($file, $this->path, 'image');

        // Update product with new image ID
        $product->update([
            'image' => $image->id,
        ]);
    }

    // Update other product details
    $product->update([
        'product_code' => $validated['product_code'],
        'name' => $validated['name'],
        'price' => $validated['price'],
        'category_id' => $validated['category_id'],
        'brand_id' => $validated['brand_id'],
        'stock' => $validated['stock'],
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}



    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
