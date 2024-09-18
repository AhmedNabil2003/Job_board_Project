<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>List Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/jobs/index.css') }}">
  
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

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div id="message"></div>
<div class="container mt-5">
    <h1 class="text-center">Jobs</h1>
    <div id="notification" class="alert d-none"></div>

    <div class="row mb-3">
        <div class="col-12">
            <input type="text" class="form-control" id="searchJob" placeholder="Search for jobs...">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-4">
            <select class="form-select" id="filterType">
                <option value="">Filter by Type</option>
                <option value="full-time">Full-time</option>
                <option value="part-time">Part-time</option>
                <option value="remote">Remote</option>
                <option value="contract">Contract</option>
                <option value="internship">Internship</option>
                <option value="freelance">Freelance</option>

            </select>
        </div>
        <div class="col-4">
        <select class="form-select" id="filterLocation">
            <option value="">Filter by Location</option>
            <option value="cairo">Cairo</option>
            <option value="giza">Giza</option>
            <option value="alexandria">Alexandria</option>
            <option value="luxor">Luxor</option>
            <option value="aswan">Aswan</option>
            <option value="sharm-el-sheikh">Sharm El Sheikh</option>
            <option value="mansoura">Mansoura</option>
        </select>
    </div>
</div>

    <div class="row">
        @foreach ($jobs as $job)
            <div class="col-md-4 mb-4">
                <div class="card job-card" data-job-id="{{ $job->id }}">
                    <div class="card-body">
                        <div class="save-icon" id="save-icon-{{ $job->id }}">
                        <i class="bi bi-bookmark-plus"></i>
                    </div>
                        <h5 class="card-title">
                            <i class="bi bi-briefcase"></i> {{ $job->title }}
                        </h5>
                        <p class="card-text">{{ $job->description }}</p>
                        <div class="job-info">
                            <p class="location"><i class="bi bi-geo-alt"></i> <strong>Location:</strong> {{ $job->location }}</p>
                            <p class="type"><i class="bi bi-clock"></i> <strong></strong> {{ $job->job_type }}</p>
                            <p class="salary"> <i class="fas fa-dollar-sign"></i><strong></strong>{{ $job->salary_min ? $job->salary_min . ' - ' . $job->salary_max : 'N/A' }}</p>
                        </div>
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
    <footer>
        <div class="container">
            <div class="row footer-links">
                <div class="col-md-3">
                    <h5>About Us</h5>
                    <a href="{{ url('/about') }}"><i class="fas fa-info-circle"></i> Our Story</a>
                    <a href="{{ url('/contact') }}"><i class="fas fa-envelope"></i> Contact</a>
                </div>
                <div class="col-md-3">
                    <h5>Support</h5>
                    <a href="{{ url('/help') }}"><i class="fas fa-life-ring"></i> Help Center</a>
                    <a href="{{ url('/faq') }}"><i class="fas fa-question-circle"></i> FAQ</a>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/job/job.js') }}"></script>
    <script>
        
document.addEventListener('DOMContentLoaded', function () {
    const saveIcons = document.querySelectorAll('.save-icon');

    saveIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const jobId = this.closest('.job-card').getAttribute('data-job-id');
            const iconElement = this.querySelector('i');
            const messageElement = document.getElementById('message'); 

            if (icon.classList.contains('saved')) {
                icon.classList.remove('saved');
                iconElement.classList.remove('bi-bookmark');
                iconElement.classList.add('bi-bookmark-plus');
            } else {
                icon.classList.add('saved');
                iconElement.classList.remove('bi-bookmark-plus');
                iconElement.classList.add('bi-bookmark');
            }

            fetch('{{ route("save.job") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ job_id: jobId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageElement.textContent = data.message; 
                    messageElement.style.color = 'green';
                } else {
                    messageElement.textContent = data.message; 
                    messageElement.style.color = 'red';
                    
                  
                    if (icon.classList.contains('saved')) {
                        icon.classList.remove('saved');
                        iconElement.classList.remove('bi-bookmark');
                        iconElement.classList.add('bi-bookmark-plus');
                    } else {
                        icon.classList.add('saved');
                        iconElement.classList.remove('bi-bookmark-plus');
                        iconElement.classList.add('bi-bookmark');
                    }
                }
            })
            .catch(error => {
                console.error('Error saving job:', error);
                messageElement.textContent = 'An error occurred while saving the job.';
                messageElement.style.color = 'red';
          
                if (icon.classList.contains('saved')) {
                    icon.classList.remove('saved');
                    iconElement.classList.remove('bi-bookmark');
                    iconElement.classList.add('bi-bookmark-plus');
                } else {
                    icon.classList.add('saved');
                    iconElement.classList.remove('bi-bookmark-plus');
                    iconElement.classList.add('bi-bookmark');
                }
            });
        });
    });
});

    </script>
</body>
</html>
