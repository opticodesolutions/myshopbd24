@extends('layout.app')
@section('title', 'Coin Transfers')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Coin Transfers</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">All Coin Transfers</h5>
                    </div>
                    <div class="card-body">
                        <!-- Display success or error messages -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Table to display coin transfers -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Amount</th>
                                    <th>Transaction ID</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coinTransfers as $transfer)
                                    <tr>
                                        <td>{{ $transfer->id }}</td>
                                        <td>{{ $transfer->sender ? $transfer->sender->name : 'Unknown' }}</td>
                                        <td>{{ $transfer->receiver ? $transfer->receiver->name : 'Unknown' }}</td>
                                        <td>{{ number_format($transfer->amount, 2) }}</td>
                                        <td>{{ $transfer->trx_id }}</td>
                                        <td>{{ ucfirst($transfer->status) }}</td>
                                        <td>{{ $transfer->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No coin transfers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
