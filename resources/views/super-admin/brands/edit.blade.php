@extends('layout.app')

@section('title', 'Edit Brand')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Brand</h1>
        </div>

        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Brand</h5>
                        <h6 class="card-subtitle text-muted">Update Brand Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('brands.update', $brand->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Brand Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $brand->name) }}" placeholder="brand Name" required>
                            </div>

                            <!-- Hidden field for `create_by` (user ID) -->
                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
