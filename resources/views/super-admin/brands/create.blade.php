@extends('layout.app')
@section('title', 'Create Brands')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Create Brand </h1>
            {{-- <a class="badge bg-primary ms-2" href="https://adminkit.io/pricing/"
                target="_blank">Pro Component <i class="fas fa-fw fa-external-link-alt"></i></a> --}}
        </div>

        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Brand</h5>
                        <h6 class="card-subtitle text-muted">Create Now</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('brands.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Brand Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Brand Name" required>
                            </div>

                            <!-- Hidden field for `create_by` (user ID) -->
                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
