@extends('layout.app')

@section('content')
    <main class="content">
        <div class="container card p-3">
            <div class="d-flex justify-content-between">
                <h1>Subscriptions</h1>
                <a href="{{ route('subscriptions.create') }}" class="btn btn-primary mb-3">Add New Subscription</a>
            </div>
            {{-- @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Per Person</th>
                            <th>Level</th>
                            <th>Ref Income</th>
                            <th>Insective Income</th>
                            <th>Daily Bonus</th>
                            <th>Admin Profit Salary</th>
                            <th>Admin Profit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ @$subscription->name }}</td>
                                <td>{{ @$subscription->description }}</td>
                                <td>{{ @$subscription->amount }}</td>
                                <td>{{ @$subscription->per_person }}</td>
                                <td>{{ @$subscription->lavel }}</td>
                                <td>{{ @$subscription->ref_income }}</td>
                                <td>{{ @$subscription->insective_income }}</td>
                                <td>{{ @$subscription->daily_bonus }}</td>
                                <td>{{ @$subscription->admin_profit_salary }}</td>
                                <td>{{ @$subscription->admin_profit }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('subscriptions.edit', $subscription->id) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $subscriptions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </main>
@endsection
