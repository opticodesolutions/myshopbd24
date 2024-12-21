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

@endsection
