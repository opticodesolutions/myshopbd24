@extends('layout.app')
@section('title', 'List of Customers')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h3>Customer List</h3>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Customers</h5>
                        <h6 class="card-subtitle text-muted">List</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Refer Code</th>
                                    {{-- <th>Total Sales</th> --}}
                                    <th>Total Commission</th>
                                    <th>Wallet Balance</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->user->name }}</td>
                                        <td>{{ $customer->user->email }}</td>
                                        <td>{{ $customer->refer_code }}</td>
                                        {{-- <td>{{ $customer->Total_Sales }}</td> --}}
                                        <td>{{ $customer->Total_sale_commission }}</td>
                                        <td>{{ $customer->wallet_balance }}</td>
                                        <td>{{ $customer->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

