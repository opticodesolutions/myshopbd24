@extends('layout.app')

@section('title', 'Purchase Now')

@section('content')
    <main class="content">
        <div class="container-fluid p-0 card p-3">
            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">User Generations List</h1>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Total Users</th>
                        <th>User IDs</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userLevels as $level => $userIds)
                        <tr>
                            <td>{{ $level }}</td>
                            <td>{{ $userCounts[$level] }}</td>
                            <td>{{ implode(', ', $userIds) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
