@extends('layout.app')

@section('title', 'Matching Commissions')
@section('content')
<main class="content">
    <div class="container-fluid p-0 card p-3">
        <div class="row">
            <!-- Matching Commissions -->
            <div class="col-12 mb-4">
                <div class="cards">
                    <div class="card-header bg-primary text-white">
                        Matching Hold Commissions
                    </div>
                    <div class="card-body">
                     <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Sale ID</th>
                                <th scope="col">Direct Bonus</th>
                                <th scope="col">Left Amount</th>
                                <th scope="col">Right Amount</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                           @if ($matching_commissions->isNotEmpty())
                                @foreach ($matching_commissions as $matching_commission)
                                    @if ($matching_commission->left_amount != 0 || $matching_commission->right_amount != 0)
                                        <tr>
                                            <td>{{ $matching_commission->sale_id }}</td>
                                            <td>{{ $matching_commission->direct_bonus }}</td>
                                            <td>{{ $matching_commission->left_amount }}</td>
                                            <td>{{ $matching_commission->right_amount }}</td>
                                            <td>{{ $matching_commission->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Matching Hold Commissions Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{-- {{ $matching_commissions->links('pagination::bootstrap-4') }} <!-- Pagination --> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
             <div class="col-12 mb-4">
                <div class="card-header bg-primary text-center text-white">
                   Matching Commissions History
                </div>
             </div>
            <!-- Downline Left Hold Bonus -->
            <div class="col-md-6">
                <div class="cards">
                    <div class="card-header bg-success text-white">
                       Matching Left Bonus
                    </div>
                    <div class="card-body">
                       <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Sale ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($downline_left_hold_bonus as $left_bonus)
                            <tr>
                                <td>{{ $left_bonus->sale_id }}</td>
                                <td>{{ $left_bonus->amount }}</td>
                                <td>{{ $left_bonus->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $downline_left_hold_bonus->links('pagination::bootstrap-4') }} --}}
                    </div>
                </div>
            </div>

            <!-- Downline Right Hold Bonus -->
            <div class="col-md-6">
                <div class="cardd">
                    <div class="card-header bg-warning text-white">
                        Matching Right Bonus
                    </div>
                    <div class="card-body">
                     <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Sale ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($downline_right_hold_bonus as $right_bonus)
                            <tr>
                                <td>{{ $right_bonus->sale_id }}</td>
                                <td>{{ $right_bonus->amount }}</td>
                                <td>{{ $right_bonus->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $downline_right_hold_bonus->links('pagination::bootstrap-4') }} --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            {{ $matching_commissions->links('pagination::bootstrap-4') }}
        </div>
    </div>
</main>
@endsection
