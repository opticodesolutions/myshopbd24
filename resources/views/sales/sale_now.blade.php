@extends('layout.app')

@section('title', 'Purchase Now')

@section('content')
@php
$customer = \App\Models\Customer::where('user_id', auth()->id())->first();
$referCode = $customer ? $customer->refer_code : '';
@endphp
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Sale Now</h1>
            {{-- <a href="{{ route('categories.index') }}" class="btn btn-secondary float-end">Back to Categories</a>
            --}}
        </div>

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Category Details</h5>
                        <h6 class="card-subtitle text-muted">Fill out the form below to create a new category.</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Package Name</label>
                                <input type="text" class="form-control @error('package_name') is-invalid @enderror" name="package_name"
       placeholder="Product Name" value="{{ old('package_name', $product->name) }}" readonly>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Seller ID</label>
                                <input type="text" class="form-control" name="user_id" value="{{ auth()->user()->id }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    name="price" placeholder="Price" value="{{ old('price', $product->price) }}"
                                    readonly>
                                @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Discount Price</label>
                                <input type="number" class="form-control @error('discount_price') is-invalid @enderror"
                                    name="discount_price" placeholder="Discount Price"
                                    value="{{ old('discount_price', $product->discount_price) }}" readonly>
                                @error('discount_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Purchase Commission</label>
                                <input type="number"
                                    class="form-control @error('purchase_commission') is-invalid @enderror"
                                    name="purchase_commission" placeholder="Purchase Commission"
                                    value="{{ old('purchase_commission', $product->purchase_commission) }}" readonly>
                                @error('purchase_commission')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input id="user_register_check" class="form-check-input" type="checkbox"
                                        name="user_register" {{ old('user_register') === 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_register_check">
                                        Register New User ?
                                    </label>
                                </div>
                                @error('user_register')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div id="user_registration_fields"
                                style="display: {{ old('user_register') === 'Yes' ? 'block' : 'none' }}">
                                <input type="hidden" name="role" value="user">

                                <div class="mb-3">
                                    <label class="form-label">New User Full name</label>
                                    <input class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        type="text" name="name" placeholder="Enter your name"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New User Email</label>
                                    <input class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        type="email" name="email" placeholder="Enter your email"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New User Password</label>
                                    <input class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        type="password" name="password" placeholder="Enter password" />
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New User Confirm Password</label>
                                    <input
                                        class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                        type="password" name="password_confirmation" placeholder="Re-enter password" />
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Saler Refer Code</label>


                                    <input
                                        class="form-control form-control-lg @error('refer_code') is-invalid @enderror"
                                        type="text" name="refer_code" placeholder="Enter refer code"
                                        value="{{ old('refer_code', $referCode) }}" readonly /> @error('refer_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror"
                                    name="payment_method">
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var userRegisterCheck = document.getElementById('user_register_check');
                var userRegistrationFields = document.getElementById('user_registration_fields');

                function toggleUserRegistrationFields() {
                    if (userRegisterCheck.checked) {
                        userRegistrationFields.style.display = 'block';
                        console.log(userRegistrationFields.style.display);
                    } else {
                        userRegistrationFields.style.display = 'none';
                        console.log(userRegistrationFields.style.display);
                    }
                }

                // Attach event listener to checkbox
                userRegisterCheck.addEventListener('change', toggleUserRegistrationFields);

                // Trigger the function on page load to set the initial state
                toggleUserRegistrationFields();
            });
        </script>
    </div>
</main>

@endsection
