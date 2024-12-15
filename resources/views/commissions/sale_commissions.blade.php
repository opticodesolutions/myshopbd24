@extends('layout.app')

@section('title', 'Income List')
@section('content')
<main class="content">
    <div class="container-fluid p-0 card p-3">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Sales Income List</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>User Name</th>
                                <th>Product Name</th>
                                <th>Transaction Type</th>
                                <th>Price</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale_commissions as $index => $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->user->name }}</td>
                                    <td>{{ $s->product->name }}</td>
                                    <td>{{ $s->transaction_type ?? 'Sales Commission' }}</td>
                                    <td>{{ $s->price ?? 'N/A' }}</td>
                                    <td>{{ $s->total_amount ?? 'N/A' }}</td>
                                    <td>{{ $s->status ?? 'N/A' }}</td>
                                    <td>{{ $s->created_at->diffForHumans() ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                             <tr>
                                <td colspan="5" class="text-right"><strong>Total Amount:</strong></td>
                                <td colspan="3"><strong>{{ number_format($totalAmount, 2) }} TK</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-container d-flex justify-content-end mt-3">
                    {{ $sale_commissions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
