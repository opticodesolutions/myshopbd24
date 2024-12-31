<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Renewal Request</title>
    <!-- Bootstrap CSS (use CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles (optional) */
        .form-container {
            margin-top: 50px;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-container .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="text-center mb-4">Subscription Renewal Request</h2>
                    <!-- Check for success message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Check for error message -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('subcription-renew.store') }}" method="POST">
                        @csrf
                        <!-- User ID (Hidden Field) -->
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <!-- Renewal Date -->
                        <div class="mb-3">
                            <label for="renewal_date" class="form-label">Renewal Date</label>
                            <input type="date" class="form-control" id="renewal_date" name="renewal_date" required>
                        </div>
                        <!-- Renewal Amount -->
                        <div class="mb-3">
                            <label for="renewal_amount" class="form-label">Renewal Amount</label>
                            <select class="form-select" id="subscription_id" name="subscription_id" required>
                                <option value="" disabled selected>Select Subscription Package</option>
                                @foreach ($subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">{{ $subscription->name }} ({{ $subscription->amount }} BDT)</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="" disabled selected>Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="Bkash">Bkash</option>
                            </select>
                        </div>
                        {{-- Remark --}}
                        <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea type="text" class="form-control" id="remarks" name="remarks" required>
                            </textarea>
                        </div>
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                            <a href="{{ route('user') }}" class="btn btn-secondary btn-lg"><i class="fa fa-arrow-left"></i> Back To Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (use CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
