@extends('layout.app')

@section('title', 'List of Jobs')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Job List</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Jobs</h5>
                        <h6 class="card-subtitle text-muted">List of Available Jobs</h6>
                    </div>
                    <div class="card-body">
                        <table id="datatables-multi" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>District</th>
                                    <th>Salary</th>
                                    <th>Posted On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                <tr>
                                    <td>{{ $job->name }}</td>
                                    <td>{{ $job->district }}</td>
                                    <td>{{ $job->salary ?? 'Not specified' }}</td>
                                    <td>{{ $job->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('join.jobs.show', $job->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                        <a href="{{ route('join.job', $job->id) }}" class="btn btn-success btn-sm">Apply</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>

<script src="{{ asset('backend/js/app.js') }}"></script>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    setTimeout(function(){
      if(localStorage.getItem('popState') !== 'shown'){
        window.notyf.open({
          type: "success",
          message: "Get access to all 500+ components and 45+ pages with AdminKit PRO. <u><a class=\"text-white\" href=\"https://adminkit.io/pricing\" target=\"_blank\">More info</a></u> ðŸš€",
          duration: 10000,
          ripple: true,
          dismissible: false,
          position: {
            x: "left",
            y: "bottom"
          }
        });

        localStorage.setItem('popState','shown');
      }
    }, 15000);
  });
</script>
@endsection
