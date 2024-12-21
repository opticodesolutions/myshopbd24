@extends('layout.app')

@section('title', 'List of Commission')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">List of Commissions</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Commissions</h5>
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
                                    <th>Commission Get</th>
                                    <th>Commission Breakdown</th>
                                    <th>Created At</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissions as $commission)
                                    <tr class="
                                        @switch($commission->transaction_type)
                                            @case('new_sale') table-success @break
                                            @case('admin_subscription_fee') table-primary @break
                                            @case('direct_bonus') table-info @break
                                            @case('downline_left_hold_bonus') table-warning @break
                                            @case('admin_profit_from_matching_commission') table-danger @break
                                            @default table-light @break
                                        @endswitch
                                    ">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $commission->id }}</td>
                                        <td>{{ $commission->sale->id ?? 'N/A' }}</td>
                                        <td>{{ $commission->sale->product->name }}</td>
                                        <td>
                                            @switch($commission->transaction_type)
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
                                                    <span class="badge bg-light text-dark">{{ $commission->transaction_type }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $commission->direct_bonus }}.TK</td>
                                        <td>
                                            <strong>Direct Bonus:</strong> {{ $commission->direct_bonus }}<br>
                                            <strong>Downline Bonus:</strong> {{ $commission->downline_bonus }}<br>
                                            <strong>Matching Bonus:</strong> {{ $commission->matching_bonus }}<br>
                                            <strong>Left Amount:</strong> {{ $commission->left_amount }}<br>
                                            <strong>Right Amount:</strong> {{ $commission->right_amount }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($commission->created_at)->format('Y-m-d H:i') }}</td>
                                        {{-- <td>
                                            <a href="{{ route('commissions.edit', $commission->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('commissions.destroy', $commission->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td> --}}
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
