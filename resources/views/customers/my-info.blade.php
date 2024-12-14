@extends('layout.app')

@section('title', 'Customer Profile')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Customer Profile</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Profile Header -->
                    <div class="card-header p-4 bg-primary text-white">
                        <div class="d-flex align-items-center">


                            @php
                            $user = Auth::user();
                            @endphp
                            @if($user->profile_picture)
                            <img src="{{ Storage::url($user->profile_picture) }}"
                                class="img-fluid rounded-circle border border-light" alt="User Avatar"
                                style="width: 150px; height: 150px;">
                            @else
                            <img src="{{ asset('backend/img/avatars/avatar.jpg') }}"
                                class="img-fluid rounded-circle border border-light" alt="User Avatar"
                                style="width: 150px; height: 150px;">
                            @endif
                            <div class="ms-4">
                                @foreach ($data as $item)
                                <h2 class="mb-0">{{ $item->user->name }}</h2>
                                <p class="mb-0">{{ $item->user->email }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Profile Body -->
                    <div class="card-body">
                        @foreach ($data as $item)
                        <div class="row mb-4">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3">My Basic Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Refer Code:</strong> {{ $item->refer_code ?? 'N/A' }}</li>
                                    <li><strong>Refer By:</strong> {{ $item->refer_by ?? 'N/A' }}</li>
                                    <li><strong>Total Sales:</strong> {{ $item->Total_Sales }}</li>
                                    <li><strong>Total Sale Commission:</strong> {{ $item->Total_sale_commission }}</li>
                                    <li><strong>Wallet Balance:</strong> {{ $item->wallet_balance }}</li>
                                    <li><strong>Join Date:</strong> {{ $item->created_at }}</li>
                                    <li><strong>Updated At:</strong> {{ $item->updated_at }}</li>
                                </ul>
                            </div>
                            
<!-- Check if parent is not null -->
@if($item->parent)
    <!-- Parent Information -->
    <div class="col-md-6">
        <h5 class="mb-3">My Parent Information</h5>
        <ul class="list-unstyled">
            <li><strong>Parent Refer Code:</strong> {{ $item->parent->refer_code ?? 'N/A' }}</li>
            <li><strong>Parent Refer By:</strong> {{ $item->parent->refer_by ?? 'N/A' }}</li>
            <li><strong>Parent Total Sale Commission:</strong>
                {{ $item->parent->Total_sale_commission ?? 'N/A' }}</li>
            <li><strong>Parent Wallet Balance:</strong> {{ $item->parent->wallet_balance ?? 'N/A' }}</li>
            <li><strong>Parent Created At:</strong> {{ $item->parent->created_at ? $item->parent->created_at->format('d M Y') : 'N/A' }}</li>
            <li><strong>Parent Updated At:</strong> {{ $item->parent->updated_at ? $item->parent->updated_at->format('d M Y') : 'N/A' }}</li>
        </ul>
    </div>
@endif

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
