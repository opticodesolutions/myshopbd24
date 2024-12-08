@extends('layout.app')
@section('title', 'Show Product')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h3>Product List</h3>
            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Product</h5>
                        <h6 class="card-subtitle text-muted">List</h6>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <img src="{{ $product->media->src }}" alt="Product Image" class="img-fluid mb-3">
                            <dl class="row">
                                <dt class="col-sm-4">Product Code:</dt>
                                <dd class="col-sm-8">{{ $product->product_code }}</dd>
                                <dt class="col-sm-4">Name:</dt>
                                <dd class="col-sm-8">{{ $product->name }}</dd>
                                <dt class="col-sm-4">Price:</dt>
                                <dd class="col-sm-8">${{ number_format($product->price, 2) }}</dd>
                                <dt class="col-sm-4">Discount Price:</dt>
                                <dd class="col-sm-8">${{ number_format($product->discount_price, 2) }}</dd>
                                <dt class="col-sm-4">Commission:</dt>
                                <dd class="col-sm-8">${{$product->commissions->sum('amount') ?? '0.00'}}</dd>
                                <dt class="col-sm-4">Description:</dt>
                                <dd class="col-sm-8">{{ $product->description }}</dd>
                                <dt class="col-sm-4">Category:</dt>
                                <dd class="col-sm-8">{{ $product->category->name }}</dd>
                                <dt class="col-sm-4">Brand:</dt>
                                <dd class="col-sm-8">{{ $product->brand->name }}</dd>
                                <dt class="col-sm-4">Stock:</dt>
                                <dd class="col-sm-8">{{ $product->stock }}</dd>
                                <dt class="col-sm-4">Created At:</dt>
                                <dd class="col-sm-8">{{ $product->created_at->format('Y-m-d H:i:s') }}</dd>
                                <dt class="col-sm-4">Updated At:</dt>
                                <dd class="col-sm-8">{{ $product->updated_at->format('Y-m-d H:i:s') }}</dd>
                            </dl>
                            <!-- Buy Button Form -->
                            <form action="{{ route('sales.store') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_price" value="{{ $product->discount_price }}">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <button type="submit" class="btn btn-primary">Buy Now</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    setTimeout(function(){
      if(localStorage.getItem('popState') !== 'shown'){
        window.notyf.open({
          type: "success",
          message: "Get access to all 500+ components and 45+ pages with AdminKit PRO. <u><a class=\"text-white\" href=\"https://adminkit.io/pricing\" target=\"_blank\">More info</a></u> 🚀",
          duration: 10000,
          ripple: true,
          dismissible: false,
          position: {
            x: "left",
            y: "bottom"
          }
        });

        localStorage.setItem('popState','shown');
      }
    }, 15000);
  });
</script>
@endsection

