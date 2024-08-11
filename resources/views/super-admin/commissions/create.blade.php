@extends('layout.app')

@section('title', 'Create Commission')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Create Commission</h1>
        </div>

        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create Commission</h5>
                        <h6 class="card-subtitle text-muted">Add New Commission Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('commissions.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <select class="form-control" name="product_id" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Commission Amount</label>
                                <input type="text" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Commission Amount" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
