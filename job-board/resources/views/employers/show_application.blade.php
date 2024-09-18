<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/employer/application.css') }}">
   
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
                                <a class="dropdown-item" href="{{ route('employer.create_jobs') }}">ADD Job</a>
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

    <div class="container mt-5">
        <div class="row">
            @forelse ($applications as $application)
                <div class="col-md-4 mb-4">
                    <div class="card application-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $application->job->title }}</h5>
                            <p class="card-text">
                                <strong>Candidate Name:</strong> {{ $application->user->name }} <br>
                                <strong>Email:</strong> {{ $application->email }} <br>
                                <strong>Phone:</strong> {{ $application->phone ?? 'N/A' }}
                            </p>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#applicationModal-{{ $application->id }}">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-info">
                        No applications found for your jobs.
                    </div>
                </div>
            @endforelse
        </div>
        <a href="{{ route('employer.dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>

    <!-- Modal Structure -->
    @foreach ($applications as $application)
        <div class="modal fade" id="applicationModal-{{ $application->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $application->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-{{ $application->id }}">Application Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Application ID:</strong> {{ $application->id }}</p>
                        <p><strong>Job Title:</strong> {{ $application->job->title }}</p>
                        <p><strong>Candidate Name:</strong> {{ $application->user->name }}</p>
                        <p><strong>Email:</strong> {{ $application->email }}</p>
                        <p><strong>Phone:</strong> {{ $application->phone ?? 'N/A' }}</p>
                        <p><strong>Resume:</strong> <a href="{{ asset('storage/' . $application->resume) }}" target="_blank">View Resume</a></p>
                        <form action="{{ route('applications.accept', $application->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Accept Application</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
