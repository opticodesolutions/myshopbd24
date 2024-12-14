@extends('layout.app')

@section('title', 'Edit Category')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Category</h1>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary float-end">Back to Categories</a>
        </div>

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Category Details</h5>
                        <h6 class="card-subtitle text-muted">Update Category Details</h6>
                    </div>
                    <div class="card-body">
                        <!-- Display validation errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}" placeholder="Category Name" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" placeholder="Category Description (Optional)">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category Image</label>
                                <input type="file" class="form-control @error('media') is-invalid @enderror" name="media" accept="image/*">
                                <small class="text-muted">Optional: Upload a new category image. Leave empty to keep the current one.</small>
                                @error('media')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>

                            <input type="hidden" name="create_by" value="{{ auth()->id() }}">

                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
