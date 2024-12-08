@extends('layout.app')
@section('title', 'Home')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3> Dashboard</h3>
                </div>
            </div>
            <div class="row">
                <h1>TopUp History</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>TRX ID</th>
                            <th>Method</th>
                            <th>Account</th>
                            <th>Notes</th>
                            <th>Admin SMS</th>
                            <th>Admin ID</th>
                            <th>Admin Type</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <td>Date</td>
                            {{-- <th>Action</th> --}}

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topups as $topup)
                            <tr>
                                <td>{{ $topup->amount }}</td>
                                <td>{{ $topup->transaction_id??'N/A' }}</td>
                                <td>{{ $topup->payment_method }}</td>
                                <td>{{ $topup->account_id??'N/A' }}</td>
                                <td>{{ $topup->notes }}</td>
                                <td>{{ $topup->created_by_sms }}</td>
                                <td>{{ $topup->created_by_user_id }}</td>
                                <td>{{ $topup->status }}</td>
                                <td>{{ $topup->created_by }}</td>
                                <td>{{ $topup->created_at }}</td>

                                {{-- <td>
                                    <button onclick="openModal('pending', {{ $topup->id }})">Pending</button>
                                    <button onclick="openModal('success', {{ $topup->id }})">Success</button>
                                    <button onclick="openModal('failed', {{ $topup->id }})">Failed</button>
                                    <button onclick="openModal('refund', {{ $topup->id }})">Refund</button>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </main>
@endsection
