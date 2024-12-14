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
                <h1>Request TopUp</h1>
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="topup">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" required>

                    <label for="payment_method">Payment Method</label>
                    <select name="payment_method" required>
                        <option value="cash">Cash</option>
                        <option value="Bkash">Bkash</option>
                    </select>

                    <label for="notes">Notes</label>
                    <textarea name="notes"></textarea>

                    <button type="submit">Submit</button>
                </form>

            </div>
        </div>
    </main>
@endsection
