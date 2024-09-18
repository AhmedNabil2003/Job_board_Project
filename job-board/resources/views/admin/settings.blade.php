<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/setting.css') }}"> <!-- Custom CSS -->
   
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">
        @if(isset($settings) && !is_null($settings->site_logo) && !is_null($settings->site_name))
                <img src="{{ asset('storage/siteLogo/' . $settings->site_logo) }}" alt="Site Logo" width="50" height="60">
                @endif
                {{ $settings->site_name }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('jobs.index') }}">Jobs</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact Us</a></li>
                @auth
                <li class="nav-item">
                    <div class="ml-auto">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    </div>
                </li>
                @else
                <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
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
<!-- Main Container -->
<section class="container mt-5">
    <h2 class="mb-4">System Settings</h2>
    <form action="{{ route('admin.updateSettings') }}" method="POST" enctype="multipart/form-data">
        @csrf
      
        <!-- Change Site Name -->
        <div class="form-group">
            <label for="siteName">Site Name:</label>
            @if($settings && $settings->site_name)
                <input type="text" class="form-control" id="siteName" name="siteName" value="{{ $settings->site_name }}">
            @else
                <input type="text" class="form-control" id="siteName" name="siteName" value="Default Name">
            @endif
        </div>
        <!-- Change Site Logo -->
        <div class="form-group">
            <label for="siteLogo">Site Logo:</label>
            <div class="profile-image-section">
                <div class="d-flex align-items-center">
                @if(isset($settings) && !is_null($settings->site_logo))
                <img id="currentLogo" src="{{ isset($settings) && $settings->site_logo ? asset('storage/siteLogo/' . $settings->site_logo) : '' }}" alt="Logo" class="profile-img-preview" style="display: {{ isset($settings) && $settings->site_logo ? 'block' : 'none' }};">
                    <span id="noLogoText" style="display: {{ isset($settings) && $settings->site_logo ? 'none' : 'block' }};">No Logo Available</span>
                @endif
                </div>
            </div>
            
            <button type="button" class="btn btn-secondary btn-secondary-custom" onclick="document.getElementById('siteLogo').click();">Change Logo</button>
            <input type="file" id="siteLogo" name="siteLogo" style="display: none;" onchange="previewImage(event)">
            <!-- Save Changes -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <!-- Delete Account Feature -->
    <hr>
    <div class="form-group">
    <h3>Delete Administrator Account</h3>
    <form action="{{ route('admin.deleteAccount', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">Delete Account</button>
        </div>
    </form>
    </div>
</section>
<!-- Delete Account Modal -->
<div id="deleteAccountModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                Are you sure you want to delete your account? This action cannot be undone.
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.deleteAccount', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/admin/logo.js') }}"></script>

</body>
</html>

