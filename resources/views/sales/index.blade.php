@extends('layout.app')

@section('title', 'List of Sales')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Sales List</h1>
                    </div>
                    <div class="card-body table-border-style table-responsive">
                        <table id="datatables-multi" class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Sell ID</th>
                                    <th>Product Code</th>
                                    <th>Product</th>
                                    <th>Seller</th>
                                    <th>Customer</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                    @auth
                                    @if (auth()->user()->hasRole('super-admin'))
                                    <th>Status</th>
                                    @endif
                                    @endauth
                                    <th>Created At</th>
                                    @auth
                                    @if (auth()->user()->hasRole('super-admin'))
                                        <th>Action</th>
                                    @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Conditionally set the data based on the user's role
                                    // $data = auth()->user()->hasRole('super-admin') ? $combinedData : $sales;
                                    $data = auth()->user()->hasRole('super-admin') ? $sales : $sales;

                                @endphp

                                @foreach($data as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->product->product_code }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ $sale->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $sale->customer->name ?? 'Unknown' }}</td>
                                    <td>{{ $sale->product->price }}</td>
                                    <td>{{ $sale->product->discount_price }}</td>
                                    @if (auth()->user()->hasRole('super-admin'))
                                    <td>
                                        <form action="{{ route('sales.updateStatus', $sale->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="this.form.submit()" style="width: 150px;">
                                                <option value="pending" {{ $sale->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $sale->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="processing" {{ $sale->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="ready" {{ $sale->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                                <option value="delivered" {{ $sale->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            </select>
                                        </form>
                                    </td>
                                    @endif
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
                    <div class="d-flex justify-content-end">
                        {{ $sales->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
