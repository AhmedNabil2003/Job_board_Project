<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">
                <img src="{{ asset('images/job_logo.jpg') }}" alt="Job Board Logo" width="50" height="60"> <!-- Logo -->
                Job Board
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                                <img src="{{ asset('storage/profile_pictures/'  . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                @endif
                                    <span class="navbar-text">{{ Auth::user()->name }}</span>
                                </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ route('profile.edit', ['id' => Auth::id()]) }}">Edit Profile</a>
                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
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

    <!-- Profile Section -->
    <section class="profile-section container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-card text-center">
                    @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                <img src="{{ asset('storage/profile_pictures/'  . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid">
                @endif
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <p class="profile-role">{{ $user->role }}</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="profile-details">
                    <h3>Profile Details</h3>
                    <ul class="list-unstyled">
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        <li><strong>Joined:</strong> {{ $user->created_at->format('F j, Y') }}</li>
                        <li><strong>Role:</strong> {{ $user->role }}</li>
                        @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                        <li><strong>bio:</strong> {{  $user->profile->bio}}</li>
                        @endif
                        <!-- Add more details as needed -->
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
