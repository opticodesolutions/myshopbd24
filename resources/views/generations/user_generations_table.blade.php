@extends('layout.app')

@section('title', 'Purchase Now')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">User Generations List</h1>
            {{-- <a href="{{ route('categories.index') }}" class="btn btn-secondary float-end">Back to Categories</a>
            --}}
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Generations</h5>
                    </div>
                    <table id="datatables-multi" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Generation</th>
                                <th>Total Members</th>
                                <th>User IDs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tableData as $row)
                            <tr>
                                <td>{{ $row['SL'] }}</td>
                                <td>{{ $row['Generation'] }} Generation</td>
                                <td>{{ $row['TotalUsers'] }}</td>
                                <td>{{ $row['UserIDs'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
