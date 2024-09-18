<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/employer/create.css') }}">
</head>
<body>
    @php
    $settings = App\Models\Setting::first();
    @endphp
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="/">
        @if(isset($settings))
            @if(!is_null($settings->site_logo))
                <img src="{{ asset('storage/siteLogo/' . $settings->site_logo) }}" alt="{{ $settings->site_name ?? 'Logo' }}" width="50" height="60">
                @endif
                @if(!is_null($settings->site_name))
                    <span>{{ $settings->site_name }}</span>
                @endif
            @endif
            </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('jobs.index') }}">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/contact') }}">Contact Us</a>
                </li>
                @auth
                <li class="nav-item">
                    <div class="ml-auto">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                                    <img src="{{ asset('storage/profile_pictures/'  . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                    <span class="navbar-text">{{ Auth::user()->name }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                <a class="dropdown-item" href="{{ route('profile.show', ['id' => Auth::id()]) }}">View Profile</a>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>

@if($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Create a New Job</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employer.store_jobs') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title:</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="requirements" class="form-label">Requirements:</label>
                            <select class="form-select" name="requirements[]" id="requirements" multiple required>
                            <option value="" disabled>Select Requirements</option>
                            <option value="Degree in Computer Science">Degree in Computer Science</option>
                            <option value="3+ years of experience">3+ years of experience</option>
                            <option value="Strong communication skills">Strong communication skills</option>
                            <option value="Knowledge of JavaScript">Knowledge of JavaScript</option>
                            <option value="Project management experience">Project management experience</option>
                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                            <option value="Master's Degree">Master's Degree</option>
                            <option value="3+ Years Experience">3+ Years Experience</option>
                            <option value="Certifications">Certifications</option>
                            <option value="Excellent Communication Skills">Excellent Communication Skills</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location:</label>
                            <select class="form-select" name="location" id="location" required>
                                <option value="" selected disabled>Filter by Location</option>
                                <option value="Cairo">Cairo</option>
                                <option value="Giza">Giza</option>
                                <option value="Alexandria">Alexandria</option>
                                <option value="Luxor">Luxor</option>
                                <option value="Aswan">Aswan</option>
                                <option value="Sharm El Sheikh">Sharm El Sheikh</option>
                                <option value="Mansoura">Mansoura</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="job_type" class="form-label">Job Type:</label>
                            <select class="form-select" name="job_type" id="job_type" required>
                                <option value="" selected disabled>Filter by Type</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Remote">Remote</option>
                                <option value="Contract">Contract</option>
                                <option value="Internship">Internship</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category:</label>
                            <select class="form-select" name="category_id" id="category_id" required>
                                <option value="" selected disabled>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="salary_min" class="form-label">Salary Min:</label>
                                <input type="number" class="form-control" name="salary_min" id="salary_min" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="salary_max" class="form-label">Salary Max:</label>
                                <input type="number" class="form-control" name="salary_max" id="salary_max" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="application_deadline" class="form-label">Application Deadline:</label>
                            <input type="date" class="form-control" name="application_deadline" id="application_deadline" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Create Job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
