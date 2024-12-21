@extends('layout.app')

@section('title', 'Queue Job')
@section('content')

    <style>
        .loader {
            width: 50px;
            aspect-ratio: 1;
            display: grid;
            border: 4px solid #0000;
            border-radius: 50%;
            border-color: #ccc #0000;
            animation: l16 1s infinite linear;
        }

        .loader::before,
        .loader::after {
            content: "";
            grid-area: 1/1;
            margin: 2px;
            border: inherit;
            border-radius: 50%;
        }

        .loader::before {
            border-color: #f03355 #0000;
            animation: inherit;
            animation-duration: .5s;
            animation-direction: reverse;
        }

        .loader::after {
            margin: 8px;
        }

        @keyframes l16 {
            100% {
                transform: rotate(1turn)
            }
        }
    </style>

    <main class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- Dashboard Card Section -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h4>Pending Jobs</h4>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="badge-custom">{{ $totalPendingJobs }} Jobs Pending</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h4>Field Jobs</h4>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="badge-custom">{{ $totalFieldJobs }} Field Jobs</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        @if ($isRunning)
                            <p>The command <strong>queue:work</strong> is currently running.</p>
                        @else
                            <p>No <strong>queue:work</strong> command is running.</p>
                        @endif
                        <!-- Process Button -->
                        <div class="text-center mb-5">
                            <button class="btn btn-primary" id="processJobButton">Process Jobs</button>
                        </div>
                        <!-- Progress Bar Section -->
                        <div id="progressContainer" style="display: none;">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" id="jobProgressBar" role="progressbar"
                                    style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <span class="progress-label" style="5px">0%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <div id="successMessage" style="display: none; color: green">Job Processed Successfully!</div>

                        <!-- Error Message -->
                        <div id="errorMessage" style="display: none; color: red">There was an error processing the job.</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card p-4">
                        <!-- Job List Section -->
                        <div class="section-header fw-bold mb-2">Job List</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Job ID</th>
                                        <th>Queue</th>
                                        <th>Attempts</th>
                                        <th>Reserved At</th>
                                        <th>Available At</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jobs as $job)
                                         <tr>
                                            <td>{{ $job->id }}</td>
                                            <td>{{ $job->queue }}</td>
                                            <td>{{ $job->attempts }}</td>
                                            <td>{{ $job->reserved_at }}</td>
                                            <td>{{ $job->available_at }}</td>
                                            <td>{{ $job->created_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No jobs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Failed Job List Section -->
                        <div class="section-header fw-bold mt-4 mb-2">Failed Job List</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Job ID</th>
                                        <th>Connection</th>
                                        <th>Queue</th>
                                        <th>Failed At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($faild as $job)
                                        <tr>
                                            <td>{{ $job->id }}</td>
                                            <td>{{ $job->connection }}</td>
                                            <td>{{ $job->queue }}</td>
                                            <td>{{ $job->failed_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No failed jobs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#processJobButton').on('click', function(e) {
                e.preventDefault();
                $('#progressContainer').show();
                var progress = 0;
                var progressBar = $('#jobProgressBar');

                // Update progress bar while waiting for the AJAX response
                var interval = setInterval(function() {
                    if (progress < 90) {
                        progress += 1;
                        updateBar(progress);
                    }
                }, 50); // Increment progress every 500ms

                // Perform AJAX request
                sendAjaxRequest();

                function updateBar(value) {
                    progressBar.css('width', value + '%');
                    progressBar.attr('aria-valuenow', value);
                    $('.progress-label').text(value + '%');
                }

                function sendAjaxRequest() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': @json(csrf_token())
                        }
                    });

                    $.ajax({
                        url: '/queue-job',
                        type: 'POST',
                        data: {
                            job_data: {
                                key: 'value'
                            }
                        },
                        success: function(response) {
                            if (response.success) {
                                clearInterval(interval); // Stop progress increments
                                updateBar(100); // Set progress to 100%
                                $('#successMessage').show();
                                $('#errorMessage').hide();
                            } else {
                                handleError(response.message || 'An error occurred.');
                            }
                        },
                        error: function(xhr) {
                            handleError('Failed to process request.');
                            console.error(xhr.responseText);
                        }
                    });
                }

                function handleError(errorMessage) {
                    clearInterval(interval); // Stop progress increments
                    progress = 0; // Reset progress
                    updateBar(progress); // Update progress bar to 0%
                    $('#errorMessage').show().text(errorMessage);
                    $('#successMessage').hide();
                }
            });

        });
    </script>
@endsection
