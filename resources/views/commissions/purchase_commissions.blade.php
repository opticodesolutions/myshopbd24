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
                                    <th>Product</th>
                                    <th>Transaction Type</th>
                                    <th>Customer</th>
                                    <th>Comission Get</th>
                                    <th>Created At</th>
                                    @auth

                                    @if (auth()->user()->hasRole('super-admin'))
                                        <th>Action</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase_commissions as $commissions)
                                <tr>
                                    <td>{{ $commissions->product->name }}</td>
                                    <td>{{ $commissions->transaction_type ?? 'Purchase Commission' }}</td>
                                    <td>{{ $commissions->user->name ?? 'Unknown' }}</td>
                                    <td class="commission">{{ $commissions->commission }}</td>



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
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="1">Total</td>
                                    <!-- This is where the total commission will be displayed -->
                                    <td id="total-commission"></td>
                                    <td></td>
                                </tr>

                            <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var commissions = document.querySelectorAll('.commission');
                                        var totalCommission = 0;

                                        commissions.forEach(function (td) {
                                            // Extract the commission value and convert it to a number
                                            var commissionValue = parseFloat(td.textContent);
                                            if (!isNaN(commissionValue)) {
                                                totalCommission += commissionValue;
                                            }
                                        });

                                        // Display the total sum in the designated element
                                        var totalElement = document.getElementById('total-commission');
                                        if (totalElement) {
                                            totalElement.textContent = totalCommission.toFixed(2) + ' TK';
                                        }
                                    });
                            </script>


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
