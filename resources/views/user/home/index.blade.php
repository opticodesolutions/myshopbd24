@extends('layout.app')
@section('title', 'Home')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3>Dashboard</h3>
                </div>
            </div>

            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-4 d-flex">
                        <div class="card flex-fill">
                            @include('user.home.partial.profile')
                        </div>
                    </div>
                    {{-- <div class="col-md-4 d-flex">
                        <div class="card flex-fill">
                            @include('user.home.partial.joinlist')
                        </div>
                    </div> --}}
                    <div class="col-md-4 d-flex">
                        <div class="card flex-fill bg-transparent shadow-none">
                            @include('user.home.partial.summary')
                        </div>
                    </div>
                </div>
            </div>

           <!-- Incentive Income Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h2 class="text-center">Incentive Income</h2>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Designation</th>
                                            <th>Children</th>
                                            <th>Matching Sale</th>
                                            <th>Text</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($incentiveIncomes as $income)
                                            <tr>
                                                <td>{{ $income->designation_name }}</td>
                                                <td>{{ $income->child_and_children }}</td>
                                                <td>{{ $income->matching_sale }}</td>
                                                <td>{{ $income->text ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $incentiveIncomes->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 
        <div class="container card p-3">
        <h1>Users Generations List</h1>

        @foreach($levelUsers as $level => $users)
            <div class="level-section">
                <h3>Level {{ $level + 1 }} ({{ count($users) }} users)</h3>

                @if(count($users) > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Refer Code</th>
                                <th>User ID</th>
                                <th>Join Date</th>
                                <th>Referred By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user['refer_code'] }}</td>
                                    <td>{{ $user['user_id'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('d M Y') }}</td>
                                    <td>{{ $user['refer_by'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No users found for this level.</p>
                @endif
            </div>
        @endforeach
    </div>



    </main>

@endsection
