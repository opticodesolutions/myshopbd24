@extends('layout.app')
@section('title', 'Home')
@section('content')
   <main class="content">
    <div class="container-fluid p-0">
        <!-- Withdraw History Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-4">Withdraw History</h1>
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
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr>
                                            <td>{{ $withdrawal->amount }}</td>
                                            <td>{{ $withdrawal->transaction_id ?? ' ' }}</td>
                                            <td>{{ $withdrawal->payment_method }}</td>
                                            <td>{{ $withdrawal->account_id ?? ' ' }}</td>
                                            <td>{{ $withdrawal->notes ?? ' ' }}</td>
                                            <td>{{ $withdrawal->created_by_sms ?? ' ' }}</td>
                                            <td>{{ $withdrawal->created_by_user_id ?? ' ' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $withdrawal->status === 'success' ? 'success' : ($withdrawal->status === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($withdrawal->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $withdrawal->created_by ?? ' ' }}</td>
                                            <td>{{ $withdrawal->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $withdrawals->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>

@endsection
