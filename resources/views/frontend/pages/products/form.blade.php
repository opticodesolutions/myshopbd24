@extends('frontend.index')
@section('content')
    <div class="mt-4">
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-12">
                    <!-- breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active" aria-current="page">Apply Now</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="mt-8 mb-8">
        <div class="col-md-12">
            <style>
                .xx {
                    padding: 50px;
                    margin-top: 50px;
                }

                .job-post {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    margin-bottom: 30px;
                }

                .job-post h3 {
                    color: #007bff;
                }

                .form-container {
                    background-color: #ffffff;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .form-container h3 {
                    color: #28a745;
                    margin-bottom: 30px;
                }

                .form-container label {
                    font-size: 16px;
                }

                .btn-submit {
                    display: block;
                    width: 100%;
                    padding: 10px;
                    background-color: #28a745;
                    color: white;
                    text-align: center;
                    border-radius: 5px;
                    font-size: 18px;
                    font-weight: bold;
                    margin-top: 20px;
                }

                .btn-submit:hover {
                    background-color: #218838;
                }

                .image-preview-container {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    border: 2px solid #ccc;
                    padding: 5px;
                    border-radius: 5px;
                    background-color: #fff;
                    display: none;
                    max-width: 150px;
                    max-height: 150px;
                }

                .image-preview-container img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            </style>

            <div class="xx">
                <!-- Job Posting Section -->
                <div class="job-post" style="text-align: center;">
                    <h1>মাই সপ ( আমার দোকান)  </h1>
<h3>কোম্পানি টু কাস্টমার ডাইরেক্ট সেলিং ই-কমার্স মার্কেটং সিস্টেম   </h3>                   <h3>সঠিক তথ্য দিয়ে নিচে দেওয়া আবেদন ফর্মটি পূরন করুন
</h3>
                    <!--<p><strong>স্থান:</strong> শেরপুর জামালপুর - ১২০ টি ইউনিয়ন</p>-->
                    <!--<p><strong>পদের সংখ্যা:</strong> মোট ৩৬০ জন (প্রতি ইউনিয়নে ৩ জন)</p>-->
                    <!--<p><strong>সেলারি:</strong> ৮,০০০ - ১০,০০০ টাকা</p>-->
                    <!--<p><strong>শর্ত:</strong> স্মার্ট মোবাইল থাকতে হবে</p>-->
                    <!--<p><strong>যোগাযোগ:</strong> বিস্তারিত জানার জন্য নিচে রেজিস্ট্রেশন ফর্ম পূরণ করুন।</p>-->
                </div>
                <!-- Registration Form Section -->
                <div class="form-container">
                    <h3>রেজিস্ট্রেশন ফর্ম</h3>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('join.job_post_save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">নাম:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Father's Name -->
                        <div class="form-group">
                            <label for="father_name">পিতার নাম:</label>
                            <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name') }}" required>
                            @error('father_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mother's Name -->
                        <div class="form-group">
                            <label for="mother_name">মাতার নাম:</label>
                            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name') }}" required>
                            @error('mother_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Voter ID -->
                        <div class="form-group">
                            <label for="voter_id">ভোটার আইডি/ জন্ম নিবন্ধন নাম্বার:</label>
                            <input type="text" class="form-control @error('voter_id') is-invalid @enderror" id="voter_id" name="voter_id" value="{{ old('voter_id') }}" required>
                            @error('voter_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mobile Number -->
                        <div class="form-group">
                            <label for="mobile_number">মোবাইল নম্বর:</label>
                            <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}" required>
                            @error('mobile_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- District -->
                        <div class="form-group">
                            <label for="district">জেলা:</label>
                            <input type="text" class="form-control @error('district') is-invalid @enderror" id="district" name="district" value="{{ old('district') }}" required>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upazila -->
                        <div class="form-group">
                            <label for="upazila">উপজেলা:</label>
                            <input type="text" class="form-control @error('upazila') is-invalid @enderror" id="upazila" name="upazila" value="{{ old('upazila') }}" required>
                            @error('upazila')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Union -->
                        <div class="form-group">
                            <label for="union">ইউনিয়ন:</label>
                            <input type="text" class="form-control @error('union') is-invalid @enderror" id="union" name="union" value="{{ old('union') }}" required>
                            @error('union')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ward Number -->
                        <div class="form-group">
                            <label for="ward_no">ওয়ার্ড নং:</label>
                            <input type="text" class="form-control @error('ward_no') is-invalid @enderror" id="ward_no" name="ward_no" value="{{ old('ward_no') }}" required>
                            @error('ward_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Village Name -->
                        <div class="form-group">
                            <label for="village_name">গ্রামের নাম:</label>
                            <input type="text" class="form-control @error('village_name') is-invalid @enderror" id="village_name" name="village_name" value="{{ old('village_name') }}" required>
                            @error('village_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nationality -->
                        <div class="form-group">
                            <label for="nationality">জাতীয়তা:</label>
                            <input type="text" class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality" value="{{ old('nationality') }}" required>
                            @error('nationality')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Religion -->
                        <div class="form-group">
                            <label for="religion">ধর্ম:</label>
                            <input type="text" class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" value="{{ old('religion') }}" required>
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Passport Image Upload -->
                        <div class="form-group">
                            <label for="passport_image">পাসপোর্ট ছবি (আপলোড করুন):</label>
                            <input type="file" class="form-control" id="passport_image" name="passport_image" accept="image/*">
                        </div>

                        <!-- Image Preview Container -->
                        <div class="image-preview-container" id="imagePreviewContainer">
                            <img id="imagePreview" src="#" alt="Image Preview" />
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit">আবেদন করুন</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Image Preview Script
        document.getElementById('passport_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    </script>

@endsection
