@extends('layout.app')
@section('title', 'Transfer Coins')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Transfer Coin</h1>
        </div>

        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Coin</h5>
                        <h6 class="card-subtitle text-muted">Transfer Now</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('coin.transfer.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="receiver_user_id" class="form-label">Receiver</label>
                                <select name="receiver_user_id" id="receiver_user_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="">Select Receiver</option>
                                    @foreach ($filteredUsers as $user)
                                        <option value="{{ $user->id }}" data-tokens="{{ $user->name }} {{ $user->id }}">
                                            {{ $user->name }} (ID: {{ $user->id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

