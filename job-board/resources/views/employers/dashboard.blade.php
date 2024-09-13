<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
</head>
<body>
    <!-- Header -->
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
                                <img src="{{ asset('storage/profile_pictures/'  . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
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
                    <!-- صورة الملف الشخصي والاسم -->
                    <li class="nav-item d-flex align-items-center mb-3">
                        <a class="navbar-brand text-light d-flex align-items-center" href="{{ route('profile.show', ['id' => Auth::id()]) }}">
                            <img src="{{ asset('storage/profile_pictures/'  . Auth::user()->profile->profile_image) }}" alt="Profile Picture" class="profile-img img-fluid rounded-circle" style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                            <div class="d-flex flex-column">
                                <p class="mb-0">{{ Auth::user()->name }}</p>
                                <span class="navbar-text">view profile</span>
                            </div>
                        </a>
                    </li>
                    </ul>
                    <!-- باقي الروابط -->
                    <ul class="nav-links flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('profile.edit', ['id' => Auth::id()]) }}">
                            <i class="fas fa-user-edit"></i>
                            Edit Profile
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.manage_jobs') }}">
                            <i class="fas fa-briefcase"></i>
                            Manage Jobs
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#">
                            <i class="fas fa-bell"></i>
                            Notifications
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#">
                            <i class="fas fa-envelope"></i>
                            Messages
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-line"></i>
                            Reports
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
                    <h5 class="card-title">Total Jobs</h5>
                    <p class="card-text">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card d-flex flex-row align-items-center">
                <div class="icon-container">
                    <i class="fas fa-file-alt"></i> <!-- Example icon -->
                </div>
                <div class="info-container">
                    <h5 class="card-title">Total Applications</h5>
                    <p class="card-text">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card d-flex flex-row align-items-center">
                <div class="icon-container">
                    <i class="fas fa-users"></i> <!-- Example icon -->
                </div>
                <div class="info-container">
                    <h5 class="card-title">New Users</h5>
                    <p class="card-text">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mb-4">
            <div class="card d-flex flex-row align-items-center">
                <div class="icon-container">
                    <i class="fas fa-bell"></i> <!-- Example icon -->
                </div>
                <div class="info-container">
                    <h5 class="card-title">Pending Notifications</h5>
                    <p class="card-text">0</p>
                </div>
            </div>
        </div>
    </div>

                <!-- Users Table -->
                <div class="container">
                    <h1> Users</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <tr>
                                    <td>name</td>
                                    <td>email</td>
                                    <td>candidate</td>
                                    <td>
                                        <a href="" class="btn btn-primary">Edit</a>
                                    </td>
                                </tr>
                          
                        </tbody>
                    </table>
                </div>

                <!-- Recent Activities -->
                <div class="recent-activities">
                    <h2>Recent Activities</h2>
                    <ul>
                        
                            <li></li>
                        
                    </ul>
                </div>

                <!-- Notifications Summary -->
                <div class="notifications-summary">
                    <h2>Notifications</h2>
                    <ul>
                       
                    </ul>
                </div>
            </main>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
