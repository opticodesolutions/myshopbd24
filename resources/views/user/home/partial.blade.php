@php
    // Get the subscription start and end dates
    $startDate = \Carbon\Carbon::parse($item->subscription_start_date);
    $endDate = \Carbon\Carbon::parse($item->subscription_end_date);
    // Get the current date
    $currentDate = \Carbon\Carbon::now()->subDays(env('EXPIRY_WARNING_DAYS', 3));

    // Get current date to check for expiring soon
    $currentDatenot = \Carbon\Carbon::now();
    // Calculate the difference in months and days
    $diffInMonths = $startDate->diffInMonths($endDate);
    $diffInDays = $startDate->diffInDays($endDate->copy()->subMonths($diffInMonths));

    // Check if the subscription has expired
    $isExpired = $currentDate->greaterThanOrEqualTo($endDate);

    // Calculate the days remaining for expiry
    $daysRemaining = floor(abs($currentDatenot->diffInDays($endDate)));

    // Check if the subscription is expiring soon (within expiry warning days)
    $isExpiringSoon = !$isExpired && $daysRemaining <= env('EXPIRY_WARNING_DAYS', 3);
@endphp

<style>
    .bg-danger {
        background-color: #dc3545 !important;
    }

    .text-white {
        color: white !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }
</style>

<li class="list-group-item py-1 {{ $isExpired ? 'bg-danger text-white' : '' }}">
    <p class="m-0">Membership Duration Remaining</p>
    @if ($isExpired)
        <span class="badge bg-danger badge-pill ps-4 pe-4">Expired</span>
        <span class="text-white">Your subscription has expired. Please renew.</span>
    @elseif ($isExpiringSoon)
        <span class="badge bg-warning badge-pill ps-4 pe-4">Expiring Soon</span>
        <span class="text-warning">Your subscription is expiring in {{ $daysRemaining }} days. Renew now!</span>
    @else
        <span class="badge bg-primary badge-pill ps-4 pe-4">{{ number_format($diffInMonths, 2) }} months</span>
    @endif
</li>

<!-- Modal -->
<div class="modal fade" id="subscriptionWarningModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="subscriptionWarningModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-danger text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="subscriptionWarningModalLabel">Subscription Warning</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($isExpired)
                    Your subscription has expired. Please renew it as soon as possible to continue enjoying our services.
                @elseif ($isExpiringSoon)
                    Your subscription is expiring in {{ $daysRemaining }} days. Renew now to avoid interruption.
                @endif
            </div>
            <div class="modal-footer">
                <a href="{{ route('subcription-renew.create') }}" class="btn btn-primary">Renew Now</a>
            </div>
        </div>
    </div>
</div>

@php
    // Set flag to show the modal if the subscription has expired or is expiring soon
    $shouldShowModal = $isExpired || $isExpiringSoon;
@endphp

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    @if ($shouldShowModal)
        // Show the modal if the subscription has expired or is expiring soon
        $(document).ready(function() {
            $('#subscriptionWarningModal').modal('show');
        });
    @endif
</script>
