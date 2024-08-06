@extends('super-admin.index')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h3>Update Product</h3>
            <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">List Product</a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Product</h5>
                        <h6 class="card-subtitle text-muted">Update</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', $product->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Code</label>
                                        <input type="text" class="form-control" name="product_code" value="{{ old('product_code', $product->product_code) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Discount Price</label>
                                        <input type="text" class="form-control" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-control" name="category_id" required>
                                            <option value="" disabled>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Brand</label>
                                        <select class="form-control" name="brand_id" required>
                                            <option value="" disabled>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <select class="form-control" id="imageSelect" name="image" required>
                                            <option value="" disabled>Select Image</option>
                                            @foreach($medias as $media)
                                                <option value="{{ $media->id }}" data-src="{{ asset($media->path) }}" {{ $product->image == $media->id ? 'selected' : '' }}>
                                                    {{ $media->src }}
                                                </option>
                                            @endforeach
                                        </select>
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

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="imagePreview" src="" alt="Image Preview">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</main>


@section('scripts')
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript for Image Preview -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var imageSelect = document.getElementById('imageSelect');
        var imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        var imagePreview = document.getElementById('imagePreview');

        imageSelect.addEventListener('change', function () {
            var selectedOption = imageSelect.options[imageSelect.selectedIndex];
            var imageUrl = selectedOption.getAttribute('data-src');

            if (imageUrl) {
                imagePreview.src = imageUrl;
                imagePreviewModal.show();
            }
        });
    });
</script>
@endsection
@endsection

