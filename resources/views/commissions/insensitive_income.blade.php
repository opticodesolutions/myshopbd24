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
                                <h2>Incentive</h2>
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
    </main>
@endsection
