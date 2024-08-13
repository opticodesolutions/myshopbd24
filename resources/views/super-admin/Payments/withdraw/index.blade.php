@extends('layout.app')
@section('title', 'Home')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3>Dashboard</h3>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center mb-4">Withdraw Request's</h1>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $topup)
                                    <tr>
                                        <td>{{ $topup->user->name }}</td>
                                        <td>{{ $topup->amount }}</td>
                                        <td>{{ ucfirst($topup->status) }}</td>
                                        <td>{{ ucfirst($topup->type) }}</td>
                                        <td>
                                            @if($topup->status !== 'pending')
                                                <button class="btn btn-secondary btn-sm" onclick="openModal('pending', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">Pending</button>
                                            @endif
                                            @if($topup->status !== 'success')
                                                <button class="btn btn-success btn-sm" onclick="openModal('success', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">Success</button>
                                            @endif
                                            @if($topup->status !== 'failed')
                                                <button class="btn btn-danger btn-sm" onclick="openModal('failed', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">Failed</button>
                                            @endif
                                            @if($topup->status !== 'refund')
                                                <button class="btn btn-warning btn-sm" onclick="openModal('refund', {{ $topup->id }}, {{ $topup->user_id }}, '{{ $topup->type }}', '{{ $topup->amount }}', '{{ $topup->payment_method }}')">Refund</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Update Payment Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('payments.updateStatus', ['id' => 'paymentId']) }}" method="POST" id="modalForm">
                            @csrf
                            <div class="modal-body">
                                <input type="hiddnen" name="status" id="modalStatus">
                                <input type="hidnjden" name="payment_id" id="paymentId">
                                <input type="hikdden" name="payment_method" id="payment_method">
                                <input type="hikdden" name="amount" id="amount">
                                <input type="hidkden" name="user_id" id="request_by">
                                <input type="hiddien" name="type" id="type">

                                <div class="form-group">
                                    <label for="createdBySms">Created By SMS</label>
                                    <input type="text" class="form-control" id="createdBySms" name="created_by_sms" value="">
                                </div>

                                <div class="form-group d-none" id="accountField">
                                    <label for="accountId">Account ID</label>
                                    <input type="text" class="form-control" id="accountId" name="account_id" value="">
                                </div>

                                <div class="form-group d-none" id="transactionField">
                                    <label for="transactionId">Transaction ID</label>
                                    <input type="text" class="form-control" id="transactionId" name="transaction_id" value="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function openModal(status, id, user_id, type, amount, payment_method) {
                    document.getElementById('modalStatus').value = status;
                    document.getElementById('paymentId').value = id;
                    document.getElementById('request_by').value = user_id;
                    document.getElementById('type').value = type;
                    document.getElementById('amount').value = amount;
                    document.getElementById('payment_method').value = payment_method;

                    document.getElementById('modalForm').action = "{{ route('payments.updateStatus', '') }}/" + id;

                    $('#paymentModal').modal('show');
                }
            </script>
        </div>
    </main>
@endsection
