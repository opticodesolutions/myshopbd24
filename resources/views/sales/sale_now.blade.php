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
        </div>

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Product Details</h5>
                        <h6 class="card-subtitle text-muted">Fill out the form below to purchase a product and optionally register a new user.</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Product Code</label>
                                <input type="text" class="form-control" name="product_code" value="{{ $product->product_code }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Package Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $product->name }}" readonly>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" name="price" value="{{ $product->price }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Discount Price</label>
                                <input type="text" class="form-control" name="discount_price" value="{{ $product->discount_price }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Purchase Commission</label>
                                <input type="text" class="form-control" name="purchase_commission" value="{{ $product->purchase_commission }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Matching Commission</label>
                                <input type="text" class="form-control" name="matching_commission" value="{{ $product->matching_commission }}" readonly>
                            </div>

                            <!-- User Registration Section -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input id="user_register_check" class="form-check-input" type="checkbox" name="user_register" {{ old('user_register') === 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_register_check">
                                        Register New User?
                                    </label>
                                </div>
                            </div>

                            <div id="user_registration_fields" style="display: {{ old('user_register') === 'Yes' ? 'block' : 'none' }}">
                                <div class="mb-3">
                                    <label class="form-label">User Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Enter full name" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter password">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm password">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <select class="form-select @error('position') is-invalid @enderror" name="position">
                                        <option value="left" {{ old('position') === 'left' ? 'selected' : '' }}>Left</option>
                                        <option value="right" {{ old('position') === 'right' ? 'selected' : '' }}>Right</option>
                                    </select>
                                    @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Position Parent</label>
                                    <input class="form-control @error('position_parent') is-invalid @enderror" type="text" name="position_parent" placeholder="Enter position parent" value="{{ old('position_parent') }}">
                                    @error('position_parent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Level</label>
                                    <input class="form-control @error('level') is-invalid @enderror" type="number" name="level" placeholder="Enter level" value="{{ old('level') }}">
                                    @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Section -->
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method">
                                    <option value="Cash" selected>Cash</option>
                                </select>
                                @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Purchase</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const userRegisterCheck = document.getElementById('user_register_check');
                const userRegistrationFields = document.getElementById('user_registration_fields');

                function toggleUserRegistrationFields() {
                    userRegistrationFields.style.display = userRegisterCheck.checked ? 'block' : 'none';
                }

                userRegisterCheck.addEventListener('change', toggleUserRegistrationFields);
                toggleUserRegistrationFields();
            });
        </script>
    </div>
</main>
@endsection
