@extends('layout.app')

@section('title', 'Income List')
@section('content')
<main class="content">
    <div class="container-fluid p-0 card p-3">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Admin Subscription Fee</h1>
        </div>

     <div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>User Name</th>
                        <th>Sale ID</th>
                        <th>Amount</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin_subscription_fee as $key => $admin_subscription)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $admin_subscription->user->name }}</td>
                            <td>{{ $admin_subscription->sale_id }}</td>
                            <td>{{ number_format($admin_subscription->amount, 2) }} TK</td>
                            <td>{{ $admin_subscription->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                    
                    <!-- Total Amount Row -->
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                        <td><strong>{{ number_format($totalAmount, 2) }} TK</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container d-flex justify-content-end mt-3">
             {{ $admin_subscription_fee->links('pagination::bootstrap-4') }}
            {{-- {{ $admin_subscription_fee->links('pagination::bootstrap-4') }} --}}
        </div>
    </div>
</div>

    </div>
</main>
@endsection
