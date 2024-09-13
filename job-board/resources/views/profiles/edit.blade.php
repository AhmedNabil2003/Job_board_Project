<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
</head>
<body>

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

<!-- Main Container -->
<section class="container mt-5">
    <h2 class="mb-4">Edit My Profile</h2>
    <form action="{{ route('profile.update', ['id' => Auth::id()]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="profile-edit-container">
        <!-- Profile Image Section -->
        <div class="profile-image-section">
            <div id="image-preview" style="margin-bottom: 15px;">
                @if($user->profile && $user->profile->profile_image)
                    <img src="{{ asset('storage/profile_pictures/' . $user->profile->profile_image) }}" alt="Profile Picture" id="current-image">
                @endif
            </div>
            <div class="custom-file">
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('profile_picture').click();">Change Profile Picture</button>
            <input type="file" id="profile_picture" name="profile_picture" style="display: none;" onchange="previewImage(event)">
            </div>
            <p class="mt-2">{{ $user->name }}</p>
        </div>

        <!-- Profile Info Section -->
        <div class="profile-info-section">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" class="form-control">{{ old('bio', $user->profile->bio) }}   
                    </textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</section>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/edit.js') }}"></script>

</body>
</html>
