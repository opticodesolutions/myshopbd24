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
                            <input type="date" class="form-control" id="renewal_date" name="renewal_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <!-- Renewal Amount -->
                        <div class="mb-3">
                            <label for="renewal_amount" class="form-label">Renewal Amount</label>
                            <select class="form-select" id="subscription_id" name="subscription_id" required>
                                <option value="" disabled selected>Select Subscription Package</option>
                                @foreach ($subscriptions as $subscription)
                                    <option data-amount="{{ $subscription->amount }}" value="{{ $subscription->id }}">{{ $subscription->name }} ({{ $subscription->amount }} BDT)</option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            use App\Models\Customer;
                            $customer = Customer::where('user_id', auth()->id())->first();
                            $expireDate = $customer->subscription_end_date;
                            $currentDate = date('Y-m-d');
                            $remainingDays = Carbon\Carbon::parse($expireDate)->diffInmonths(Carbon\Carbon::parse($currentDate));
                            $roundedMonths = round($remainingDays); 
                            if ($remainingDays - floor($remainingDays) >= 0.01) {
                                $roundedMonths = ceil($remainingDays); 
                            }
                        @endphp
                        {{-- Amount --}}
                        <div class="mb-3">
                            <label for="month" class="form-label">Your Required Month</label>
                            <input type="number" step="0.01" value="{{ $roundedMonths }}" class="form-control" id="month" name="month" readonly required>
                        </div>

                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" readonly required>
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
    <script type="text/javascript">
        // Listen for changes in the subscription dropdown
    document.getElementById('subscription_id').addEventListener('change', function() {
        // Get the selected option and retrieve the data-amount attribute
        const selectedOption = this.options[this.selectedIndex];
        const subscriptionAmount = parseFloat(selectedOption.getAttribute('data-amount'));
        
        // Get the number of months from the readonly input field
        const months = parseFloat(document.getElementById('month').value);
        
        // Calculate the total amount
        const totalAmount = subscriptionAmount * months;
        
        // Update the total amount input field
        document.getElementById('total_amount').value = totalAmount.toFixed(2); 
    });

    window.addEventListener('load', function() {
        const selectedOption = document.getElementById('subscription_id').options[document.getElementById('subscription_id').selectedIndex];
        const subscriptionAmount = parseFloat(selectedOption.getAttribute('data-amount'));
        const months = parseFloat(document.getElementById('month').value);
        const totalAmount = subscriptionAmount * months;
        document.getElementById('total_amount').value = totalAmount.toFixed(2); 
    });
    </script>
</body>
</html>
