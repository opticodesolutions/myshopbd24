@extends('layout.app')

@section('title', 'List of Brand')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle"> Personal</h1>
        </div>

        <div class="row ">
            <div class="col-lg-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Personal</h5>
                        <h6 class="card-subtitle text-muted">Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                                                        @php
                            $user = Auth::user();
                            @endphp
                            @if($user->profile_picture)
                            <img src="{{ Storage::url($user->profile_picture) }}"
                                class="img-fluid rounded-circle border border-light" alt="User Avatar"
                                style="width: 150px; height: 150px;">
                            @else
                                                        <img src="{{ asset('backend/img/avatars/avatar.jpg') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110" height="110">

                            @endif
                            <div class="mt-3">
                                <h4>{{$data->user->name}}</h4>
                                <p class="text-secondary mb-1"><span style="padding-bottom: 5px;" class="pl-4 pr-4 badge bg-secondary badge-pill">Customer ID</span></p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="user-context">
                            <table class="w-100 table table-bordered mt-3">
                                <tbody><tr>
                                    <td><b>Name</b></td>
                                    <td><b>{{ $data->user->name }}</b></td>
                                </tr>
                                <tr>
                                    <th><b>ID</b></th>
                                    <td><b>{{ $data->user_id }}</b></td>
                                </tr>
                                <tr>
                                    <th>ID Status</th>
                                    <td>
                                        <span class="badge bg-secondary badge-pill ps-3 pe-3 font-14">Member</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>{{ $data->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Rank</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Father</th>
                                    <td>{{ $data->user->father_name }}</td>
                                </tr>
                                <tr>
                                    <th>Mother</th>
                                    <td>{{ $data->user->mother_name }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile </th>
                                    <td>{{ $data->user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth </th>
                                    <td>{{ $data->user->date_of_birth }}</td>
                                </tr>
                                <tr>
                                    <th>Gender </th>
                                    <td>Male</td>
                                </tr>
                                <tr>
                                    <th>National ID</th>
                                    <td>{{ $data->user->national_id }}</td>
                                </tr>
                                <tr>
                                    <th>Religion</th>
                                    <td>{{ $data->user->religion }}</td>
                                </tr>
                                <tr>
                                    <th>Blood Group</th>
                                    <td>{{ $data->user->blood_group }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $data->user->address }}</td>
                                    <!--<td style="padding: 0;">-->
                                    <!--    <table class="table table-bordered m-0">-->
                                    <!--        <tbody><tr>-->
                                    <!--            <th>Division</th>-->
                                    <!--            <td>Mymensingh</td>-->
                                    <!--        </tr>-->
                                    <!--        <tr>-->
                                    <!--            <th>District</th>-->
                                    <!--            <td>Sherpur</td>-->
                                    <!--        </tr>-->
                                    <!--        <tr>-->
                                    <!--            <th>Thana</th>-->
                                    <!--            <td>Sherpur Sadar</td>-->
                                    <!--        </tr>-->
                                    <!--        <tr>-->
                                    <!--            <th>Union</th>-->
                                    <!--            <td>Char Sherpur</td>-->
                                    <!--        </tr>-->
                                    <!--        <tr>-->
                                    <!--            <th>Word</th>-->
                                    <!--            <td></td>-->
                                    <!--        </tr>-->
                                    <!--        <tr>-->
                                    <!--            <th colspan="2" class="text-center bg-light">Address ↓</th>-->
                                    <!--        </tr>-->
                                    <!--        <tr>-->
                                    <!--            <td colspan="2"></td>-->
                                    <!--        </tr>-->
                                    <!--    </tbody></table>-->
                                    <!--</td>-->
                                </tr>
                                <tr>
                                    <th>Refer to you</th>
                                    <td>{{$parent->user->name.' ' }}({{$parent->refer_code}})</td>
                                </tr>
                                <tr>
                                    <th>Placement ID</th>
                                    <td>{{$data->user->name}} ({{$data->refer_code}})</td>
                                </tr>

                                @php
                                use Carbon\Carbon;

                                // Assuming $data->created_at is a Carbon instance, otherwise you should convert it.
                                $joinDate = Carbon::parse($data->created_at);
                                $now = Carbon::now();
                                $diff = $joinDate->diff($now);

                                $years = $diff->y;
                                $months = $diff->m;
                                $days = $diff->d;
                            @endphp

                            <tr>
                                <th>Join Date</th>
                                <td>{{ $joinDate->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Join Age</th>
                                <td>
                                    {{ $years }} Year - {{ $months }} Month - {{ $days }} Day
                                </td>
                            </tr>

                                <tr>
                                    <th>Team</th>
                                    <td>
                                        {{ \App\Models\Customer::where('refer_by', $data->refer_code)->count() }}
                                    </td>
                                </tr>

                                <!--<tr>-->
                                <!--    <th>A HP </th>-->
                                <!--    <td>300</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <th>B HP </th>-->
                                <!--    <td>0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <th>My HP </th>-->
                                <!--    <td>50</td>-->
                                <!--</tr>-->

                            </tbody></table>
                        </div>
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
          message: "Get access to all 500+ components and 45+ pages with AdminKit PRO. <u><a class=\"text-white\" href=\"https://adminkit.io/pricing\" target=\"_blank\">More info</a></u> 🚀",
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
