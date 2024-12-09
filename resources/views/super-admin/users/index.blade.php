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
                        <h6 class="card-subtitle text-muted">List of all customers and their details</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    {{-- <th>Sale ID</th> --}}
                                    <th>Refer Code</th>
                                    <th>Referred By</th>
                                    <th>Position Parent</th>
                                    <th>Position</th>
                                    <th>Level</th>
                                    {{-- <th>Total Sales</th>
                                    <th>Total Sale Commission</th>
                                    <th>Matching Commission</th> --}}
                                    <th>Wallet Balance</th>
                                    <th>Subscription Start Date</th>
                                    <th>Subscription End Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->user_id }}</td>
                                        {{-- <td>{{ $customer->sale_id ?? 'N/A' }}</td> --}}
                                        <td>{{ $customer->refer_code }}</td>
                                        <td>{{ $customer->refer_by ?? 'None' }}</td>
                                        <td>{{ $customer->position_parent ?? 'None' }}</td>
                                        <td>{{ $customer->position ?? 'None' }}</td>
                                        <td>{{ $customer->level ?? 'N/A' }}</td>
                                        {{-- <td>{{ $customer->Total_Sales }} TK</td>
                                        <td>{{ $customer->Total_sale_commission }} TK</td>
                                        <td>{{ $customer->matching_commission }} TK</td> --}}
                                        <td>{{ $customer->wallet_balance }} TK</td>
                                        <td>{{ $customer->subscription_start_date ?? 'Not Available' }}</td>
                                        <td>{{ $customer->subscription_end_date ?? 'Not Available' }}</td>
                                        <td>{{ $customer->created_at ?? 'N/A' }}</td>
                                        <td>{{ $customer->updated_at ?? 'N/A' }}</td>
                                        <td>
                                            {{-- <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
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
