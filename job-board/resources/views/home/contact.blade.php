<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Job Board</title>
    <link rel="stylesheet" href="{{ asset('css/sgin/about.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .hero-section {
            background: url('{{ asset('images/background4.jpg') }}') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 60px 0;
            position: relative;
        }
        .contact-info {
            margin-top: 30px;
        }
        .contact-info .info-item {
            margin-bottom: 1.5rem;
        }
        .contact-form {
            margin-top: 30px;
        }
        .contact-form .form-group {
            margin-bottom: 1.5rem;
        }
        .contact-form button {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
@php
    $settings = App\Models\Setting::first();
    $categories = App\Models\Category::all(); // Load all categories
    $jobs = App\Models\JobListing::latest()->take(6)->get(); // Get only 5 latest jobs
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
                        <a class="nav-link active" href="{{ url('/contact') }}">Contact Us</a>
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
                                    @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                                        <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                    @endif
                                    <span class="navbar-text">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">User Dashboard</a>
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

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you. Please use the form below to reach out.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <h2>Get in Touch</h2>
            
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="info-item">
                    <h5><i class="fas fa-map-marker-alt"></i> Address</h5>
                    <p>{{ $settings->contact_address ?? '1234 Street Name, City, Country' }}</p>
                </div>
                <div class="info-item">
                    <h5><i class="fas fa-phone"></i> Phone</h5>
                    <p>{{ $settings->contact_phone ?? '+1234567890' }}</p>
                </div>
                <div class="info-item">
                    <h5><i class="fas fa-envelope"></i> Email</h5>
                    <p><a href="mailto:{{ $settings->contact_email ?? 'info@example.com' }}">{{ $settings->contact_email ?? 'info@example.com' }}</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
