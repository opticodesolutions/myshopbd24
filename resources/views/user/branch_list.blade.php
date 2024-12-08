@extends('layout.app')
@section('title', 'Home')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Branch's </h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Branch</h5>
                        <h6 class="card-subtitle text-muted">List</h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-multi" class="table table-striped" style="width:100%">
                            <thead>
                                    <th>Sl</th>
                                    <th>Branch Name</th>
                                    <th>Branch Location</th>
                            </thead>
                            <tbody>
                                    <tr>
                                        <th>01</th>
                                        <th>Main Branch Sherpur</th>
                                        <th>Collage Mor Sherpur Town, Sherpur</th>
                                    </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
@endsection