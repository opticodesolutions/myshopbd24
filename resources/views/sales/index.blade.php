@extends('layout.app')

@section('title', 'List of Brand')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Sales </h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Brand</h5>
                        <h6 class="card-subtitle text-muted">List</h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-multi" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                    <th>Commission</th>
                                    <th>Created At</th>
                                    @auth

                                    @if (auth()->user()->hasRole('super-admin'))
                                        <th>Action</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->product->product_code }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ $sale->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $sale->product->price }}</td>
                                    <td>{{ $sale->product->discount_price }}</td>
                                    <td>
                                        {{ $sale->commission }}
                                    </td>
                                    <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                    @auth
                                    @if (auth()->user()->hasRole('super-admin'))
                                        <td>
                                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
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
