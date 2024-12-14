@extends('layout.app')

@section('title', 'List of Brand')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Password</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Password</h5>
                        <h6 class="card-subtitle text-muted">Change</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       name="current_password" placeholder="Current Password" required>
                                @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       name="new_password" placeholder="New Password" required>
                                @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                       name="new_password_confirmation" placeholder="Confirm New Password" required>
                                @error('new_password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>


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
