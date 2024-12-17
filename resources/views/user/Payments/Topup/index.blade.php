@extends('layout.app')
@section('title', 'Home')
@section('content')
    <main class="content">
    <div class="container-fluid p-0">
        <!-- TopUp History Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-4">TopUp History</h1>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Amount</th>
                                        <th>TRX ID</th>
                                        <th>Method</th>
                                        <th>Account</th>
                                        <th>Notes</th>
                                        <th>Admin SMS</th>
                                        <th>Admin ID</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topups as $topup)
                                        <tr>
                                            <td>{{ $topup->amount }}</td>
                                            <td>{{ $topup->transaction_id ?? '  ' }}</td>
                                            <td>{{ $topup->payment_method }}</td>
                                            <td>{{ $topup->account_id ?? '  ' }}</td>
                                            <td>{{ $topup->notes ?? '  ' }}</td>
                                            <td>{{ $topup->created_by_sms ?? '  ' }}</td>
                                            <td>{{ $topup->created_by_user_id ?? '  ' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $topup->status === 'success' ? 'success' : ($topup->status === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($topup->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $topup->created_by ?? '  ' }}</td>
                                            <td>{{ $topup->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $topups->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
