@extends('layout.app')
@section('title', 'Edit Product')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2>Update Product</h2>
                            <a href="{{ route('products.index') }}" class="btn btn-primary mb-3"><i class="fas fa-list"></i> List Product</a>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 col-xl-6">
                                        <div class="mb-3">
                                            <label class="form-label">Product Code</label>
                                            <input type="text" class="form-control" name="product_code"
                                                value="{{ old('product_code', $product->product_code) }}"
                                                placeholder="Product Code" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Product Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $product->name) }}" placeholder="Product Name"
                                                required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Buy Price</label>
                                            <input type="text" class="form-control" name="price"
                                                value="{{ old('price', $product->price) }}" placeholder="Buy Price" required />
                                        </div>
                                       <div class="mb-3">
                                           <label class="form-label">Sell Price</label>
                                          <input type="text" class="form-control" name="discount_price"
                                            value="{{ old('discount_price', $product->discount_price) }}"
                                                placeholder="Sell Price" />
                                        </div>
                                         {{-- purchase_commission --}}

                                        <div class="mb-3">
                                            <label class="form-label">Purchase Coin</label>
                                            <input type="number" class="form-control" name="purchase_commission"
                                                value="{{ old('purchase_commission', $product->purchase_commission) }}"
                                                placeholder="Purchase Commission" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" class="form-control" name="stock"
                                                value="{{ old('stock', $product->stock) }}" placeholder="Stock Quantity"
                                                required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" placeholder="Description">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xl-6">
                                        <!-- Category and Brand fields -->
                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select class="form-control" name="category_id" required>
                                                <option value="" disabled>Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Brand</label>
                                            <select class="form-control" name="brand_id" required>
                                                <option value="" disabled>Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $brand->id == old('brand_id', $product->brand_id) ? 'selected' : '' }}>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Image Upload Section -->
                                        <div class="mb-3">
                                            <label class="form-label">Images</label>
                                            <div id="image-input-container">
                                                <input type="file" class="form-control" name="image[]"
                                                    accept="image/*" />
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary mt-2"
                                                onclick="addImageInput()">Add Another Image</button>

                                            <!-- Display existing images -->
                                            @if ($medias->isNotEmpty())
                                                <div class="mt-3">
                                                    <label class="form-label">Current Images</label>
                                                    <div class="row">
                                                        @foreach ($medias as $media)
                                                            <div class="col-3">
                                                                <img src="{{ asset('storage/' . $media->media->src) }}"
                                                                    alt="Product Image" class="img-thumbnail"
                                                                    style="max-width: 150px;">
                                                                <button type="button" class="btn btn-sm btn-danger mt-2"
                                                                    onclick="removeImage({{ $media->id }})">Remove</button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

<script>
    function addImageInput() {
        const container = document.getElementById('image-input-container');
        const input = document.createElement('input');
        input.type = 'file';
        input.className = 'form-control mt-2';
        input.name = 'image[]';
        input.accept = 'image/*';
        container.appendChild(input);
    }

    function removeImage(imageId) {
        if (confirm('Are you sure you want to remove this image?')) {
            console.log('Remove image with ID:', imageId);
        }
    }
</script>
