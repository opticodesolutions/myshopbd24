@extends('layout.app')
@section('title', 'Subscription Renewal History')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <!-- Subscription Renewal History Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-4">Subscription Renewal History</h1>
                        
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('subcription-renew.index') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="status" class="form-select" aria-label="Select Status">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Renewal Date</th>
                                        <th>Renewal Amount</th>
                                        <th>Payment Method</th>
                                        <th>Remark</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subcription_renewal as $renewal)
                                        <tr>
                                            <td>{{ $renewal->user_id }}</td>
                                            <td>{{ $renewal->renewal_date }}</td>
                                            <td>{{ $renewal->renewal_amount }}</td>
                                            <td>{{ $renewal->payment_method }}</td>
                                            <td>{{ $renewal->remarks ?? 'No remarks' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $renewal->payment_status === 'approved' ? 'success' : ($renewal->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($renewal->payment_status) }}
                                                </span>
                                            </td>
                                            <td>{{ $renewal->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="#UpdateModal" 
                                                    class="btn btn-primary btn-sm editButton" 
                                                    data-bs-toggle="modal" 
                                                    data-id="{{ $renewal->id }}" 
                                                    data-renewal-date="{{ $renewal->renewal_date }}" 
                                                    data-renewal-amount="{{ $renewal->renewal_amount }}" 
                                                    data-payment-method="{{ $renewal->payment_method }}" 
                                                    data-remark="{{ $renewal->remarks }}" 
                                                    data-status="{{ $renewal->payment_status }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('subcription-renew.destroy', $renewal->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $renewal->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>  
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $subcription_renewal->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Modal --}}
<!-- Update Modal -->
<div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="UpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateModalLabel">Update Subscription Renewal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('subcription-renew.update', 0) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Renewal Date -->
        <div class="col-md-6 mb-3">
            <label for="renewal_date" class="form-label">Renewal Date</label>
            <input type="date" class="form-control" id="renewal_date" name="renewal_date" required>
        </div>

        <!-- Renewal Amount -->
        <div class="col-md-6 mb-3">
            <label for="renewal_amount" class="form-label">Renewal Amount</label>
            <input type="number" step="0.01" class="form-control" id="renewal_amount" name="renewal_amount" readonly required>
        </div>
    </div>

    <div class="row">
        <!-- Payment Method -->
        <div class="col-md-6 mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="" disabled selected>Select Payment Method</option>
                <option value="cash">Cash</option>
                <option value="Bkash">Bkash</option>
            </select>
        </div>

        <!-- Remark -->
        <div class="col-md-6 mb-3">
            <label for="remark" class="form-label">Remark</label>
            <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
        </div>
    </div>

    <div class="row">
        <!-- Status -->
        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="" disabled selected>Select Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
            </select>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.editButton');
        const updateModal = document.getElementById('UpdateModal');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const renewalId = this.dataset.id;
                const renewalDate = this.dataset.renewalDate;
                const renewalAmount = this.dataset.renewalAmount;
                const paymentMethod = this.dataset.paymentMethod;
                const remark = this.dataset.remark;
                const status = this.dataset.status;

                // Populate modal fields
                updateModal.querySelector('#renewal_date').value = renewalDate;
                updateModal.querySelector('#renewal_amount').value = renewalAmount;
                updateModal.querySelector('#payment_method').value = paymentMethod;
                updateModal.querySelector('#remark').value = remark || '';
                updateModal.querySelector('#status').value = status;

                // Update the form action
                const form = updateModal.querySelector('form');
                form.action = form.action.replace(/\d+$/, renewalId);
            });
        });
    });
</script>
@endsection
