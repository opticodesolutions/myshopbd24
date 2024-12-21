@extends('layout.app')

@section('title', 'List of Customers')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                         <h3>Customer List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>SL</th>
                                        <th>ID</th>
                                        <th>User ID</th>
                                        <th>Refer Code</th>
                                        <th>Referred By</th>
                                        <th>Position Parent</th>
                                        <th>Position</th>
                                        <th>Level</th>
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
                                            <td>{{ $customer->refer_code }}</td>
                                            <td>{{ $customer->refer_by ?? 'None' }}</td>
                                            <td>{{ $customer->position_parent ?? 'None' }}</td>
                                            <td>{{ $customer->position ?? 'None' }}</td>
                                            <td>{{ $customer->level ?? 'N/A' }}</td>
                                            <td>{{ $customer->wallet_balance }} TK</td>
                                            <td>{{ $customer->subscription_start_date ?? 'Not Available' }}</td>
                                            <td>{{ $customer->subscription_end_date ?? 'Not Available' }}</td>
                                            <td>{{ $customer->created_at ?? 'N/A' }}</td>
                                            <td>{{ $customer->updated_at ?? 'N/A' }}</td>
                                            <td>
                                                <form action="{{ route('admin.users.distroy', $customer->user_id) }}" method="GET" style="display:inline;">
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
    </div>
</main>
@endsection
