<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/jobs/job-details.css') }}">
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
            <ul class="navbar-nav ms-auto">
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
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                            <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
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

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card job-details-card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">{{ $job->title }}</h2>
                    <p class="card-text"><i class="bi bi-briefcase"></i> {{ $job->description }}</p>

                    <div class="job-info mt-4">
                        <p><i class="bi bi-geo-alt"></i> <strong>Location:</strong> {{ $job->location }}</p>
                        <p><i class="bi bi-clock"></i> <strong>Type:</strong> {{ $job->job_type }}</p>
                        <p><i class="fas fa-dollar-sign"></i> <strong>Salary:</strong> {{ $job->salary_min ? $job->salary_min . ' - ' . $job->salary_max : 'N/A' }}</p>
                        <p><i class="bi bi-calendar"></i> <strong>Application Deadline:</strong> {{ $job->application_deadline ? $job->application_deadline->format('F j, Y') : 'N/A' }}</p>
                        <p><i class="bi bi-info-circle"></i> <strong>Status:</strong> {{ ucfirst($job->status) }}</p>
                        <p><i class="bi bi-check-circle"></i> <strong>Requirements:</strong> {{ $job->requirements ?? 'N/A' }}</p>
                       
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Back to Listings</a>
                        <a href="{{ route('candidate.savedjobs') }}" class="btn btn-secondary">Back to Saved Jobs</a>
                        <a href="{{ route('job.apply', ['job' => $job->id]) }}" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
