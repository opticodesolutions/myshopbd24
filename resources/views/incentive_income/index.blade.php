@extends('layout.app')
@section('title', 'Incentive Income List')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <!-- Incentive Income Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2>Incentive Income List</h2>
                                <a href="{{ route('incentive_income.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Incentive Income
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Designation</th>
                                            <th>Children</th>
                                            <th>Matching Sale</th>
                                            <th>Amount</th>
                                            <th>Text</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($incentiveIncomes as $income)
                                            <tr>
                                                <td>{{ $income->designation_name }}</td>
                                                <td>{{ $income->child_and_children }}</td>
                                                <td>{{ $income->matching_sale }}</td>
                                                <td>{{ $income->amount }}</td>
                                                <td>{{ $income->text ?? '' }}</td>
                                                <td>
                                                    <a href="{{ route('incentive_income.edit', $income->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('incentive_income.destroy', $income->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?')">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
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
    </main>
@endsection
