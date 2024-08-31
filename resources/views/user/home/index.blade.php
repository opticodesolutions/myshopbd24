@extends('layout.app')
@section('title', 'Home')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3>Dashboard</h3>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Income</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ number_format($Total_transactions_amount-$Total_withdrawn_amount, 2) }}
            </h1>
            <div class="mb-0">
                <span class="badge badge-success-light">3.65%</span>
                <span class="text-muted">Since last week</span>
            </div>
        </div>
    </div>
    </div> --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Orders</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="shopping-bag"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $Total_sells }}</h1>
                <div class="mb-0">
                    <span class="badge badge-danger-light">-5.25%</span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Commission's</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="activity"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $Total_commission_transactions }}</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light">4.65%</span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Commission</h5>
                            </div>
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ number_format($Total_sells_commission, 2) }}</h1>
    <div class="mb-0">
        <span class="badge badge-success-light">2.35%</span>
        <span class="text-muted">Since last week</span>
    </div>
    </div>
    </div>
    </div> --}}
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Commission Balance</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($Total_commission_transaction, 2) }}</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light">3.65%</span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Topup</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($Total_topup_amount, 2) }}</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light">3.65%</span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Total Withdraw </h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($Total_withdrawn_amount, 2) }}</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light">3.65%</span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Current Balance</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($Balance_customer, 2) }}</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light">3.65%</span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">All Transations </h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($Total_transactions_amount, 2) }}</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light">3.65%</span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>

        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">

                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('join.png')}}" class="m-2" alt="icon" style="border-radius:50%"
                                    width="120" height="120">

                                <div class="mt-3 mb-3">
                                    <h4 class="text-capitalize">Latest Joining</h4>
                                </div>
                            </div>
                            <marquee direction="up" onmouseover="this.stop()" onmouseout="this.start()">
                                <ul class="list-group   list-group-flush">
                                    @foreach ($latest_users as $item)
                                    <li class="list-group-item bg-transparent ">
                                        <p class="m-0">{{ $item->user->name }}</p>
                                        <span class="badge bg-primary badge-pill ps-4 pe-4">{{ $item->user_id }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </marquee>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('Goals.png')}}" class="m-2" alt="icon" style="border-radius:50%"
                                    width="120" height="120">

                                <div class="mt-3 mb-3">
                                    <h4 class="text-capitalize ">Top Achievers</h4>
                                </div>
                            </div>
                            <marquee direction="up" onmouseover="this.stop()" onmouseout="this.start()">
                                <ul class="list-group   list-group-flush">
                                    @foreach ($top_earner as $item)
                                    <li class="list-group-item bg-transparent ">
                                        <p class="m-0">{{ $item->user->name }}</p>
                                        <span class="badge bg-success badge-pill ps-4 pe-4">{{ $item->user_id }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </marquee>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            @foreach ($data as $item)
                            <div class="d-flex flex-column align-items-center text-center">
                                @if($item->user->profile_picture)
                                <img src="{{ Storage::url($item->user->profile_picture) }}" id="user1.png" class="m-2"
                                    alt="icon" style="border-radius:50%" width="120" height="120">
                                @else
                                <img src="{{ asset('backend/img/avatars/avatar.jpg') }}" id="user1.png" class="m-2"
                                    alt="icon" style="border-radius:50%" width="120" height="120">
                                @endif
                                <div class="mt-3 mb-3">
                                    <h4 class="text-capitalize"> <span id="ContentPlaceHolder1_txtName"
                                            class="progress-description">{{ $item->user->name }}</span></h4>

                                </div>
                            </div>
                            @php
$balance = number_format($Balance_customer, 2);
$target = -500; // Target balance for 100% progress
$remainingAmount = max(500, -$balance); // How much is needed to reach 0
$progress = $balance < 0 ? min(100, ((-$balance) / (-$target)) * 100) : 0; // Calculate progress if balance < 0 // Calculate progress if balance < 0
@endphp

            <!-- Display only if balance is less than 0 -->


                            <ul class="list-group   list-group-flush">
                                <li class="list-group-item bg-transparent py-1 ">
                                    <p class="m-0">Sponsor</p>
                                    <span class="badge bg-success badge-pill ps-4 pe-4">{{ $item->refer_by }}</span>
                                </li>
                                <li class="list-group-item bg-transparent py-2 ">
                                    <p class="m-0">Account Type</p>


                                    @if($balance < 0)
                                    <span style="padding-bottom: 5px;"
                                    class="pl-4 pr-4 badge bg-secondary badge-pill">Processing</span>
                                    <div class="">
                                        <label class="form-label">Current Balance: {{ $balance }}</label>

                                        {{-- <label class="form-label">Remaining to Reach 0: ${{ $remainingAmount }}</label> --}}
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ 100-$progress }}%;" aria-valuenow="{{ 100-$progress }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format(100-$progress, 2) }}%
                                            </div>
                                        </div>
                                    </div>

                                    @else
                                    <span style="padding-bottom: 5px;"
                                        class="pl-4 pr-4 badge bg-secondary badge-pill">Customer</span>
                                    @endif




                                </li>
                                <li class="list-group-item bg-transparent py-2 ">
                                    <p class="m-0">Mobile No</p>
                                    <span
                                        class="badge bg-secondary badge-pill ps-4 pe-4">{{ $item->mobile ?? '01968402925' }}</span>
                                </li>
                                <li class="list-group-item bg-transparent py-1 ">
                                    <p class="m-0">E-mail</p>
                                    <span class="badge bg-secondary badge-pill ps-4 pe-4">{{$item->user->email}}</span>
                                </li>

                            </ul>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
</main>

@endsection
