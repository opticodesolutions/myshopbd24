@extends('layout.app')
@section('title', 'Edit Incentive Income')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <!-- Edit Incentive Income Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="mb-4">Edit Incentive Income</h1>

                            <form action="{{ route('incentive_income.update', $incentiveIncome->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="designation_name" class="form-label">Designation Name</label>
                                    <input type="text" class="form-control" id="designation_name" name="designation_name" value="{{ old('designation_name', $incentiveIncome->designation_name) }}" required>
                                    @error('designation_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="child_and_children" class="form-label">Children and Children</label>
                                    <input type="number" class="form-control" id="child_and_children" name="child_and_children" value="{{ old('child_and_children', $incentiveIncome->child_and_children) }}" required>
                                    @error('child_and_children')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="matching_sale" class="form-label">Matching Sale</label>
                                    <input type="number" class="form-control" id="matching_sale" name="matching_sale" value="{{ old('matching_sale', $incentiveIncome->matching_sale) }}" required>
                                    @error('matching_sale')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $incentiveIncome->amount) }}" required>
                                    @error('amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="text" class="form-label">Text</label>
                                    <input type="text" class="form-control" id="text" name="text" value="{{ old('text', $incentiveIncome->text) }}">
                                    @error('text')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
