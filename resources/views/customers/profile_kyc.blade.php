@extends('layout.app')

@section('title', 'List of Brand')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Pofile Kyc</h1>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Profile</h5>
                        <h6 class="card-subtitle text-muted">Kyc</h6>
                    </div>
                    <div class="d-flex flex-column align-items-center text-center">
                        @if($user->profile_picture)
                        <img id="image-preview" src="{{ Storage::url($user->profile_picture) }}" alt="Profile Picture" class="rounded-circle p-1 bg-primary" width="110" height="110">
                        <div class="mt-3">
                            <h4>{{ $user->name }}</h4>
                            <p class="text-secondary mb-1"><span style="padding-bottom: 5px;" class="pl-4 pr-4 badge bg-secondary badge-pill">Customer ID {{ $user->id }}</span></p>
                        </div>
                        @else
                        <div class="avatar-placeholder" style="width: 150px; height: 150px; background-color: #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span style="color: #fff; font-size: 24px;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kyc.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Father's Name</label>
                                <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name', $user->father_name) }}">
                                @error('father_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mother's Name</label>
                                <input type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ old('mother_name', $user->mother_name) }}">
                                @error('mother_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nominee Name</label>
                                <input type="text" class="form-control @error('nominee_name') is-invalid @enderror" name="nominee_name" value="{{ old('nominee_name', $user->nominee_name) }}">
                                @error('nominee_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Religion</label>
                                <input type="text" class="form-control @error('religion') is-invalid @enderror" name="religion" value="{{ old('religion', $user->religion) }}">
                                @error('religion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Blood Group</label>
                                <input type="text" class="form-control @error('blood_group') is-invalid @enderror" name="blood_group" value="{{ old('blood_group', $user->blood_group) }}">
                                @error('blood_group')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">National ID</label>
                                <input type="text" class="form-control @error('national_id') is-invalid @enderror" name="national_id" value="{{ old('national_id', $user->national_id) }}">
                                @error('national_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                @error('date_of_birth')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" class="form-control @error('profession') is-invalid @enderror" name="profession" value="{{ old('profession', $user->profession) }}">
                                @error('profession')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" name="profile_picture">
                                @error('profile_picture')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
@endsection
