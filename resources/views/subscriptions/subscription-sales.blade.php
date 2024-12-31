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
                                <th>Actions</th>
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
                                        <form action="{{ route('subscription_sales.updateStatus', $sale->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="this.form.submit()" style="width: 150px;">
                                                <option value="pending" {{ $sale->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $sale->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="failed" {{ $sale->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                    <form action="#" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  onsubmit="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </button>
                                    </form>
                                    </td>
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
