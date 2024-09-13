<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light">
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
                    <a class="nav-link home-link active" href="{{ url('/') }}">Home <span class="badge badge-primary">New</span></a>
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/help') }}">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/features') }}">Features</a>
                </li>
                @auth
                <li class="nav-item">
                <div class="ml-auto">
                <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                    <span class="navbar-text">{{ Auth::user()->name }}</span>
                                </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('dashboard') }}" >User Dashboard</a>
                                <a class="dropdown-item" href="{{ route('profile.show', ['id' => Auth::user()->id]) }}">View Profile</a>
                                <a class="dropdown-item" href="{{ route('profile.edit', ['id' => Auth::id()]) }}">Edit Profile</a>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                   @csrf
                                <button class="dropdown-item" type="submit">Logout</button>     
                                      </form>
                            </div>
                        </div>
                    </div>
                </li>      
                    @else
                <li class="nav-item">
                    <span class="separator">|</span>
                    <a class="nav-link" href="/login">Login</a>
                </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>

<main>
    <div id="backgroundCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#backgroundCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#backgroundCarousel" data-slide-to="1"></li>
            <li data-target="#backgroundCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset('images/background2.jpg') }}');">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">Welcome to the Job Board</h1>
                    <p class="lead">Find your dream job or post your listing.</p>
                    <a class="btn btn-light btn-lg" href="/jobs" role="button">Browse Jobs</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/background1.jpg') }}');">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">Explore New Opportunities</h1>
                    <p class="lead">Browse hundreds of job listings.</p>
                    <a class="btn btn-light btn-lg" href="/jobs" role="button">Browse Jobs</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/background3.jpg') }}');">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">Join Us Today</h1>
                    <p class="lead">Sign up and start your journey.</p>
                    <a class="btn btn-light btn-lg" href="/register" role="button">Register Now</a>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#backgroundCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#backgroundCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</main>

<footer class="text-center mt-5 py-4">
    <p>&copy; 2024 Job Board</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
