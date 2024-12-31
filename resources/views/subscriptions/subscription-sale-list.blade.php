@extends('layout.app')

@section('title', 'Subscription Sales')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Subscription Sales</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Subscription Sales Data</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>SL</th>
                                <th>Subscription ID</th>
                                <th>User ID</th>
                                <th>Customer ID</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptionSales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->subscription->name }}</td>
                                    <td>{{ $sale->user_id }}</td>
                                    <td>{{ $sale->customer_id }}</td>
                                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                                    <td> 
                                        {!! $sale->status == 'pending' ? '<span class="text-warning">Pending</span>' : 
                                            ($sale->status == 'approved' ? '<span class="text-success">Approved</span>' : 
                                            '<span class="text-danger">Cancelled</span>') 
                                        !!}
                                    </td>
                                    <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $subscriptionSales->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
