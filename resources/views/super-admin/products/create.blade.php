@extends('layout.app')
@section('title', 'Create Product')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Product</h2>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mb-3"><i class="fas fa-list"></i> Product List</a>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Code</label>
                                        <input type="number" class="form-control" name="product_code" placeholder="Product Code" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Product Name" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Buy Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="Buy Price" required />
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Sell Price</label>
                                        <input type="number" class="form-control" name="discount_price" placeholder="Sell Price" />
                                    </div>
                                    {{-- purchase_commission --}}

                                    <div class="mb-3">
                                        <label class="form-label">Purchase Coin</label>
                                        <input type="number" class="form-control" name="purchase_commission" placeholder="Purchase Commission" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="stock" placeholder="Stock Quantity" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-control" name="category_id" required>
                                            <option value="" disabled selected>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Brand</label>
                                        <select class="form-control" name="brand_id" required>
                                            <option value="" disabled selected>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Images</label>
                                        <div id="image-input-container">
                                            <div class="image-input mb-2">
                                                <input type="file" class="form-control" name="image[]" accept="image/*" onchange="previewImage(event, 0)" required />
                                                <img id="preview-0" src="#" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 150px;" />
                                                <button type="button" class="btn btn-danger mt-2 remove-image-button" onclick="removeImageInput(this)">Remove</button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary" id="add-image-button">Add Another Image</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    let imageCount = 1;

    function previewImage(event, index) {
        let reader = new FileReader();
        reader.onload = function(){
            let output = document.getElementById('preview-' + index);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('add-image-button').addEventListener('click', function() {
        let container = document.getElementById('image-input-container');
        let newImageInput = document.createElement('div');
        newImageInput.classList.add('image-input', 'mb-2');
        newImageInput.innerHTML = `
            <input type="file" class="form-control" name="image[]" accept="image/*" onchange="previewImage(event, ${imageCount})" required />
            <img id="preview-${imageCount}" src="#" alt="Image Preview" class="img-thumbnail mt-2" style="display:none; max-width: 150px;" />
            <button type="button" class="btn btn-danger mt-2 remove-image-button" onclick="removeImageInput(this)">Remove</button>
        `;
        container.appendChild(newImageInput);
        imageCount++;
    });

    function removeImageInput(button) {
        button.closest('.image-input').remove();
    }
</script>
@endsection
