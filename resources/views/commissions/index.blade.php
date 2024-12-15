@extends('layout.app')

@section('title', 'List Refer Commissions')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h3 d-inline align-middle">Refer Commissions</h1>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatables-multi" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>TRX ID</th>
                                        <th>Sale ID</th>
                                        <th>User Name</th>
                                        <th>Transaction Type</th>
                                        <th>Customer</th>
                                        <th>Commission Get</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commissions as $index => $commission)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $commission->id }}</td>
                                            <td>{{ $commission->sale_id ?? 'N/A' }}</td>
                                            <td>{{ $commission->user->name ?? 'Unknown' }}</td>
                                            <td>{{ $commission->transaction_type ?? 'N/A' }}</td>
                                            <td>{{ $commission->customer->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($commission->amount, 2) }}</td>
                                            <td>{{ $commission->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                 <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-right"><strong>Total Commission:</strong></td>
                                        <td colspan="2"><strong>{{ number_format($totalCommission, 2) }} TK</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="pagination-container d-flex justify-content-end mt-3">
                            {{ $commissions->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
