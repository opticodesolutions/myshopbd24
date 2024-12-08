@extends('layout.app')

@section('title', 'Job Details')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Job Details</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Job Information</h5>
                    </div>
                    <div class="card-body" style="display: flex; flex-direction: row; justify-content: space-between;">

                        <!-- Left Section (Job Details) -->
                        <div style="flex: 1; max-width: 60%; padding-right: 20px;">
                            <p><strong>Job Title:</strong> {{ $job->name }}</p>
                            <p><strong>Father's Name:</strong> {{ $job->father_name }}</p>
                            <p><strong>Mother's Name:</strong> {{ $job->mother_name }}</p>
                            <p><strong>Voter ID:</strong> {{ $job->voter_id }}</p>
                            <p><strong>Mobile Number:</strong> {{ $job->mobile_number }}</p>
                            <p><strong>District:</strong> {{ $job->district }}</p>
                            <p><strong>Upazila:</strong> {{ $job->upazila }}</p>
                            <p><strong>Union:</strong> {{ $job->union }}</p>
                            <p><strong>Ward Number:</strong> {{ $job->ward_no }}</p>
                            <p><strong>Village Name:</strong> {{ $job->village_name }}</p>
                            <p><strong>Nationality:</strong> {{ $job->nationality }}</p>
                            <p><strong>Religion:</strong> {{ $job->religion }}</p>
                            <p><strong>Created At:</strong> {{ $job->created_at->format('Y-m-d H:i') }}</p>
                        </div>

                        <!-- Right Section (Passport Image) -->
                        <div style="flex: 1; max-width: 35%; text-align: center;">
                            @if($job->passport_image)
                                <p><strong>Passport Image:</strong></p>
                                <img src="{{ asset('storage/' . $job->passport_image) }}" alt="Passport Image" class="img-fluid" style="max-width: 100%; border: 2px solid #ddd; padding: 5px; border-radius: 5px;">
                            @else
                                <p>No passport image available.</p>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <a href="{{ route('join.job_list') }}" class="btn btn-secondary mt-3">Back to Job List</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@section('styles')
<style>
    /* A4 Page Design */
    .content {
        font-family: Arial, sans-serif;
        padding: 20px;
        background: #f4f4f4;
        max-width: 210mm; /* A4 paper width */
        margin: 0 auto;
    }

    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: #ffffff;
    }

    .card-header {
        background-color: #f8f9fa;
        padding: 20px;
        border-bottom: 2px solid #ddd;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 20px;
    }

    .card-footer {
        background-color: #f8f9fa;
        padding: 10px;
        border-top: 2px solid #ddd;
    }

    p {
        margin: 10px 0;
        font-size: 14px;
    }

    strong {
        font-weight: 600;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    /* Responsive Adjustments */
    @media print {
        .content {
            margin: 0;
            max-width: 210mm; /* A4 size */
            padding: 10mm;
        }

        .card {
            box-shadow: none;
        }

        .card-header,
        .card-footer {
            background-color: transparent;
            border: none;
        }

        .btn-secondary {
            display: none;
        }
    }

    /* Image Styling */
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection
