@extends('layout.app')

@section('title', 'Password Change')

@section('content')
    @php $users = App\Models\User::all(); @endphp
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="user_id">Select User</label>
                                <select name="user_id" id="user_id" class="form-control select2" required>
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }} -
                                            {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user_id').select2(); // Apply Select2 to the select box
        });
    </script>
@endsection
