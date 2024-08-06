@extends('super-admin.index')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Category</h1>
        </div>

        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Category</h5>
                        <h6 class="card-subtitle text-muted">Update Category Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categories.update', $category->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" placeholder="Category Name" required>
                            </div>

                            <!-- Hidden field for `create_by` (user ID) -->
                            <input type="hidden" name="create_by" value="{{ auth()->id() }}">

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
