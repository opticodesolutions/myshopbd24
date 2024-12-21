@extends('layout.app')

@section('title', 'List of Brand')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Commission's </h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Commission</h5>
                        <h6 class="card-subtitle text-muted">List</h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-multi" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>TRX ID</th>
                                    <th>Sale ID</th>
                                    <th>Product</th>
                                    <th>Transaction Type</th>
                                    <th>Customer</th>
                                    <th>Commission Get</th>
                                    <th>Commission By</th>
                                    <th>Created At</th>
                                    @auth
                                        @if (auth()->user()->hasRole('super-admin'))
                                            <th>Action</th>
                                        @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($all as $commissions)
                                    <tr class="
                                        @switch($commissions->transaction_type)
                                            @case('new_sale') table-success @break
                                            @case('admin_subscription_fee') table-primary @break
                                            @case('direct_bonus') table-info @break
                                            @case('downline_left_hold_bonus') table-warning @break
                                            @case('admin_profit_from_matching_commission') table-danger @break
                                            @default table-light @break
                                        @endswitch
                                    ">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $commissions->id }}</td>
                                        <td>{{ $commissions->sale->id }}</td>
                                        <td>{{ $commissions->sale->product->name }}</td>
                                        <td>
                                            @switch($commissions->transaction_type)
                                                @case('admin_profit_from_matching_commission')
                                                    <span class="badge bg-dark text-light">Admin Profit From Matching Commission</span>
                                                    @break
                                                @case('new_sale')
                                                    <span class="badge bg-success text-light">New Sale</span>
                                                    @break
                                                @case('admin_subscription_fee')
                                                    <span class="badge bg-primary text-light">Admin Subscription Fee</span>
                                                    @break
                                                @case('direct_bonus')
                                                    <span class="badge bg-info text-light">Direct Bonus</span>
                                                    @break
                                                @case('downline_left_hold_bonus')
                                                    <span class="badge bg-warning text-dark">Downline Left Hold Bonus</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $commissions->transaction_type }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $commissions->user->name ?? 'Unknown' }}</td>
                                        <td>{{ $commissions->amount }}.TK</td>
                                        <td>
                                            Name: {{ $commissions->sale->user->name ?? 'Unknown' }}<br>
                                            ID: {{ $commissions->sale->user->id }}<br>
                                            Refer Code: {{ $commissions->sale->user->customer->refer_code }}
                                        </td>
                                        <td>{{ $commissions->created_at->format('Y-m-d H:i') }}</td>

                                        @auth
                                            @if (auth()->user()->hasRole('super-admin'))
                                                <td>
                                                    <form action="{{ route('sales.destroy', $commissions->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td>
                                            @endif
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
<script src="{{ asset('backend/js/app.js') }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    setTimeout(function(){
      if(localStorage.getItem('popState') !== 'shown'){
        window.notyf.open({
          type: "success",
          message: "Get access to all 500+ components and 45+ pages with AdminKit PRO. <u><a class=\"text-white\" href=\"https://adminkit.io/pricing\" target=\"_blank\">More info</a></u> 🚀",
          duration: 10000,
          ripple: true,
          dismissible: false,
          position: {
            x: "left",
            y: "bottom"
          }
        });

        localStorage.setItem('popState','shown');
      }
    }, 15000);
  });
</script>
@endsection
