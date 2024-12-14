@extends('layout.app')

@section('title', 'List of Brand')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Insensitive </h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <h5 class="card-title"> Income</h5>
                        <h6 class="card-subtitle text-muted">List</h6>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="w-100 table table-bordered">
                                    <thead>

                                        <tr style="text-align: center">
                                            <th>SL</th>
                                            <th>Rank</th>
                                            <th>Seller</th>
                                            <th>Reward</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center">
                                            <td>1</td>
                                            <td>Basic Saller(BS)</td>
                                            <td style="text-align: center;">30 Seller</td>

                                            <td style="text-align: center;"> Family Dinner 3 Person / TK.1000</td>
                                            <td>
                                                <div
                                                    class="d-flex align-items-center justify-content-center text-danger">
                                                    <i
                                                        class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                                    <span>Pending</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr style="text-align: center">
                                            <td>2</td>
                                            <td>Standerd Saller(SS)</td>
                                            <td style="text-align: center;">10 Basic Seller</td>

                                            <td style="text-align: center;"> Cox Bazar Tour 1 Person / TK.5000</td>
                                            <td>
                                                <div
                                                    class="d-flex align-items-center justify-content-center text-danger">
                                                    <i
                                                        class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                                    <span>Pending</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr style="text-align: center">
                                            <td>3</td>
                                            <td>Premium Saller(PS)</td>
                                            <td style="text-align: center;">10 Standerd Seller</td>

                                            <td style="text-align: center;"> TK.20,000</td>
                                            <td>
                                                <div
                                                    class="d-flex align-items-center justify-content-center text-danger">
                                                    <i
                                                        class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                                    <span>Pending</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr style="text-align: center">
                                            <td>4</td>
                                            <td>Gold Saller(GS)</td>
                                            <td style="text-align: center;">5 Premium Seller</td>

                                            <td style="text-align: center;"> Umra Tour 1 Person / TK.1,50,000</td>
                                            <td>
                                                <div
                                                    class="d-flex align-items-center justify-content-center text-danger">
                                                    <i
                                                        class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                                    <span>Pending</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr style="text-align: center">
                                            <td>5</td>
                                            <td>Diamond Saller(DS)</td>
                                            <td style="text-align: center;">3 Gold Seller</td>

                                            <td style="text-align: center;"> Car  / TK.10,00,000</td>
                                            <td>
                                                <div
                                                    class="d-flex align-items-center justify-content-center text-danger">
                                                    <i
                                                        class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                                    <span>Pending</span>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr style="text-align: center">
                                            <td>6</td>
                                            <td>Messaging Pertnerer(MP)</td>
                                            <td style="text-align: center;">2 Diamond Seller</td>

                                            <td style="text-align: center;"> 2% Commission with Tk.60000/100000 Per Month </td>
                                            <td>
                                                <div
                                                    class="d-flex align-items-center justify-content-center text-danger">
                                                    <i
                                                        class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                                    <span>Pending</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>

    </div>
</main>
<script src="{{ asset('backend/js/app.js') }}"></script>
@endsection
