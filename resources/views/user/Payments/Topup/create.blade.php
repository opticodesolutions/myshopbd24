@extends('layout.app')
@section('title', 'Home')
@section('content')
  <main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="mb-4">Request TopUp</h1>
                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf
                            <!-- Hidden Fields -->
                            <input type="hidden" name="type" value="topup">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <!-- Amount Field -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" required>
                            </div>

                            <!-- Payment Method Field -->
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="cash">Cash</option>
                                    <option value="Bkash">Bkash</option>
                                </select>
                            </div>

                            <!-- Notes Field -->
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
