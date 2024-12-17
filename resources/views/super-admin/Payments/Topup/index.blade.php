@extends('layout.app')
@section('title', 'Home')
@section('content')
  <main class="content">
    <div class="container-fluid p-0">
        <div class="container card pt-3">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Top-Up Requests</h1>

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topups as $topup)
                                    <tr>
                                        <td>{{ $topup->user->name }}</td>
                                        <td>${{ number_format($topup->amount, 2) }}</td>
                                        <td>
                                            <span class="badge 
                                                {{ $topup->status === 'pending' ? 'bg-warning' : '' }}
                                                {{ $topup->status === 'success' ? 'bg-success' : '' }}
                                                {{ $topup->status === 'failed' ? 'bg-danger' : '' }}
                                                {{ $topup->status === 'refund' ? 'bg-info' : '' }}">
                                                {{ ucfirst($topup->status) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($topup->type) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if($topup->status !== 'pending')
                                                    <button class="btn btn-secondary btn-sm"
                                                        onclick="openModal('pending', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">
                                                        Pending
                                                    </button>
                                                @endif
                                                @if($topup->status !== 'success')
                                                    <button class="btn btn-success btn-sm"
                                                        onclick="openModal('success', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">
                                                        Success
                                                    </button>
                                                @endif
                                                @if($topup->status !== 'failed')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="openModal('failed', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">
                                                        Failed
                                                    </button>
                                                @endif
                                                @if($topup->status !== 'refund')
                                                    <button class="btn btn-warning btn-sm"
                                                        onclick="openModal('refund', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">
                                                        Refund
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Top-Up Requests Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $topups->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Update Payment Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('payments.updateStatus', ['id' => 'paymentId']) }}" method="POST" id="modalForm">
                        @csrf
                        <div class="modal-body">
                                                      
                            <div class="row mb-3">
    <div class="col-md-6">
        <label for="modalStatus" class="form-label">Status</label>
        <input type="text" class="form-control" id="modalStatus" name="status" readonly>
    </div>
    <div class="col-md-6">
        <label for="paymentId" class="form-label">Payment ID</label>
        <input type="text" class="form-control" id="paymentId" name="payment_id" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="payment_method" class="form-label">Payment Method</label>
        <input type="text" class="form-control" id="payment_method" name="payment_method" readonly>
    </div>
    <div class="col-md-6">
        <label for="amount" class="form-label">Amount</label>
        <input type="text" class="form-control" id="amount" name="amount" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="request_by" class="form-label">User ID</label>
        <input type="text" class="form-control" id="request_by" name="user_id" readonly>
    </div>
    <div class="col-md-6">
        <label for="type" class="form-label">Type</label>
        <input type="text" class="form-control" id="type" name="type" readonly>
    </div>
</div>


                            <div class="mb-3">
                                <label for="createdBySms" class="form-label">Created By SMS</label>
                                <input type="text" class="form-control" id="createdBySms" name="created_by_sms" value="">
                            </div>

                            <div class="mb-3 d-none" id="accountField">
                                <label for="accountId" class="form-label">Account ID</label>
                                <input type="text" class="form-control" id="accountId" name="account_id" value="">
                            </div>

                            <div class="mb-3 d-none" id="transactionField">
                                <label for="transactionId" class="form-label">Transaction ID</label>
                                <input type="text" class="form-control" id="transactionId" name="transaction_id" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Trigger Script -->
        <script>
            function openModal(status, id, user_id, type, amount, payment_method) {
                document.getElementById('modalStatus').value = status;
                document.getElementById('paymentId').value = id;
                document.getElementById('request_by').value = user_id;
                document.getElementById('type').value = type;
                document.getElementById('amount').value = amount;
                document.getElementById('payment_method').value = payment_method;

                document.getElementById('modalForm').action = "{{ route('payments.updateStatus', '') }}/" + id;

                new bootstrap.Modal(document.getElementById('paymentModal')).show();
            }
        </script>
    </div>
</main>

@endsection
