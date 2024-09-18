<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>candidate Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
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
                                @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                                <img src="{{ asset('storage/profile_pictures/'  . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                @endif
                                  <span class="navbar-text">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('profile.show', ['id' => Auth::id()]) }}">View Profile</a>
                                    <a class="dropdown-item" href="{{ route('profile.edit', ['id' => Auth::id()]) }}">Edit Profile</a>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Container -->
    <section id="main-container" class="inner-dashboard container-fluid left-main">
    <div class="row">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-wrapper col-md-4 col-sm-12 col-xs-12">
            <div class="sidebar-sticky bg-dark">
                <ul class="nav flex-column">
                    <li class="nav-item d-flex align-items-center mb-3">
                        <a class="navbar-brand text-light d-flex align-items-center" href="{{ route('profile.show', ['id' => Auth::id()]) }}">
                        @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                                <img src="{{ asset('storage/profile_pictures/'  . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                @endif
                                 <div class="d-flex flex-column">
                                <p class="mb-0">{{ Auth::user()->name }}</p>
                                <span class="navbar-text">view profile</span>
                            </div>
                        </a>
                    </li>
                    </ul>
                    <ul class="nav-links flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('profile.edit', ['id' => Auth::id()]) }}">
                            <i class="fas fa-user-edit"></i>
                            Edit Profile
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('candidate.savedjobs') }}">
                            <i class="fas fa-save"></i> 
                            Saved Jobs
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('applications.show') }}">
                        <i class="fas fa-file-alt"></i>
                            Applications
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('candidate.messages') }}">
                            <i class="fas fa-envelope"></i>
                            Messages
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('candidate.settings') }}">
                            <i class="fas fa-cogs"></i> 
                            Account Settings
                        </a>
                    </li>
                </ul>

            </div>
        </aside>
            @endauth

            <!-- Main Content -->
            <main id="main-content" class="col-md-8 col-sm-12 col-xs-12">
    <!-- Dashboard Summary -->
    <div class="dashboard-summary row">
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card d-flex flex-row align-items-center">
                <div class="icon-container">
                    <i class="fas fa-briefcase"></i> <!-- Example icon -->
                </div>
                    <div class="info-container">
                    <h5 class="card-title">Total Jobs Saved</h5>
                    <p class="card-text">{{ $jobs->count() }}</p>
                </div>
                </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card d-flex flex-row align-items-center">
                <div class="icon-container">
                    <i class="fas fa-file-alt"></i> <!-- Example icon -->
                </div>
                <div class="info-container">
                    <h5 class="card-title"> Total Application</h5>
                    <p class="card-text">{{ $totalApplications }} </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card d-flex flex-row align-items-center">
                <div class="icon-container">
                    <i class="fas fa-bell"></i> <!-- Example icon -->
                </div>
                <div class="info-container">
                    <h5 class="card-title">New messages</h5>
                    <p class="card-text">{{ $newMessagesCount }}</p>
                </div>
            </div>
        </div>
    </div>
  
 <!-- Users Table -->
<div class="col-md-8">
    <div class="profile-details">
        <h3>Profile Details</h3>
        <div class="row">
            <!-- Profile Image Section -->
            <div class="col-md-4 text-center">
                @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                    <div class="profile-card">
                        <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle">
                    </div>
                @endif
            </div>

            <!-- Profile Details Section -->
            <div class="col-md-8">
                <ul class="list-unstyled">
                    <li><strong class="detail-label">Name:</strong> <span class="detail-value">{{ $user->name }}</span></li>
                    <li><strong class="detail-label">Email:</strong> <span class="detail-value">{{ $user->email }}</span></li>
                    <li><strong class="detail-label">Joined:</strong> <span class="detail-value">{{ $user->created_at->format('F j, Y') }}</span></li>
                    <li><strong class="detail-label">Role:</strong> <span class="detail-value">{{ $user->role }}</span></li>
                    @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                        <li><strong class="detail-label">Bio:</strong> <span class="detail-value">{{ $user->profile->bio }}</span></li>
                    @endif
                    <li><strong class="detail-label">Company Name:</strong> <span class="detail-value">{{ Auth::user()->profile->company_name ?? 'N/A' }}</span></li>
                    <li><strong class="detail-label">Location:</strong> <span class="detail-value">{{ Auth::user()->profile->location ?? 'N/A' }}</span></li>
                    <!-- Add more details as needed -->
                </ul>
            </div>
        </div>
    </div>
</div>


            </main>
        </div>
    </section>
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

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
