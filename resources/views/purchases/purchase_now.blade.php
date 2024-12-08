@extends('layout.app')

@section('title', 'Purchase Now')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Purchase Now</h1>
            {{-- <a href="{{ route('categories.index') }}" class="btn btn-secondary float-end">Back to Categories</a> --}}
        </div>

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Category Details</h5>
                        <h6 class="card-subtitle text-muted">Fill out the form below to create a new category.</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('purchase.save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Product Name" value="{{ old('name', $product->name) }}" readonly>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="Price" value="{{ old('price', $product->price) }}" readonly>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Discout Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="discount_price" placeholder="Price" value="{{ old('discount_price', $product->discount_price) }}" readonly>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Purchase Commission</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" name="purchase_commission" placeholder="Price" value="{{ old('purchase_commission', $product->purchase_commission) }}" readonly>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- //payment method --}}
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method">
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash" selected>Cash</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
