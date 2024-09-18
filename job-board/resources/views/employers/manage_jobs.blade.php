<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - Job Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/manage_jobs.css') }}">
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

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">
    <h1 class="text-center">Manage Jobs</h1>

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
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Remote">Remote</option>
                <option value="Contract">Contract</option>
                <option value="Internship">Internship</option>
                <option value="Freelance">Freelance</option>
            </select>
        </div>
        <div class="col-4">
            <select class="form-select" id="filterStatus">
                <option value="">Filter by Status</option>
                <option value="Active">Active</option>
                <option value="Closed">Closed</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="jobsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ $job->job_type }}</td>
                            <td>
                                @if ($job->status == 'Active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Closed</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewJobModal-{{ $job->id }}">View</button>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editJobModal-{{ $job->id }}" data-id="{{ $job->id }}" data-title="{{ $job->title }}" data-location="{{ $job->location }}" data-job_type="{{ $job->job_type }}" data-status="{{ $job->status }}">Edit</button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $job->id }}">Delete</button>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@foreach ($jobs as $job)
<div class="modal fade" id="editJobModal-{{ $job->id }}" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJobModalLabel">Edit Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('employer.update_job', $job->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="jobTitle" class="form-label">Job Title</label>
                        <input type="text" class="form-control" id="jobTitle" name="title" value="{{ $job->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <select class="form-select" name="location" id="location" required>
                            <option value="" selected disabled>Filter by Location</option>
                            <option value="Cairo" {{ $job->location == 'Cairo' ? 'selected' : '' }}>Cairo</option>
                            <option value="Giza" {{ $job->location == 'Giza' ? 'selected' : '' }}>Giza</option>
                            <option value="Alexandria" {{ $job->location == 'Alexandria' ? 'selected' : '' }}>Alexandria</option>
                            <option value="Luxor" {{ $job->location == 'Luxor' ? 'selected' : '' }}>Luxor</option>
                            <option value="Aswan" {{ $job->location == 'Aswan' ? 'selected' : '' }}>Aswan</option>
                            <option value="Sharm El Sheikh" {{ $job->location == 'Sharm El Sheikh' ? 'selected' : '' }}>Sharm El Sheikh</option>
                            <option value="Mansoura" {{ $job->location == 'Mansoura' ? 'selected' : '' }}>Mansoura</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jobType" class="form-label">Job Type</label>
                        <select class="form-select" id="jobType" name="job_type" required>
                            <option value="Full-time" {{ $job->job_type == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="Part-time" {{ $job->job_type == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="Remote" {{ $job->job_type == 'Remote' ? 'selected' : '' }}>Remote</option>
                                <option value="Contract" {{ $job->job_type == 'Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="Internship" {{ $job->job_type == 'Internship' ? 'selected' : '' }}>Internship</option>
                                <option value="Freelance" {{ $job->job_type == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jobDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="jobDescription" name="description" rows="3">{{ $job->description }}</textarea>
                    </div>
                    <div class="mb-3">
                    <label for="jobRequirements" class="form-label">Requirements</label>
                    <select class="form-select" id="jobRequirements" name="requirements" required>
                        <option value="" selected disabled>Select Requirements</option>
                        <option value="Degree in Computer Science" {{ $job->requirements == 'Degree in Computer Science' ? 'selected' : '' }}>Degree in Computer Science</option>
                        <option value="3+ years of experience" {{ $job->requirements == '3+ years of experience' ? 'selected' : '' }}>3+ years of experience</option>
                        <option value="Strong communication skills" {{ $job->requirements == 'Strong communication skills' ? 'selected' : '' }}>Strong communication skills</option>
                        <option value="Knowledge of JavaScript" {{ $job->requirements == 'Knowledge of JavaScript' ? 'selected' : '' }}>Knowledge of JavaScript</option>
                        <option value="Project management experience" {{ $job->requirements == 'Project management experience' ? 'selected' : '' }}>Project management experience</option>
                        <option value="Bachelor's Degree" {{ $job->requirements == "Bachelor's Degree" ? 'selected' : '' }}>Bachelor's Degree</option>
                        <option value="Master's Degree" {{ $job->requirements == "Master's Degree" ? 'selected' : '' }}>Master's Degree</option>
                        <option value="Certifications" {{ $job->requirements == 'Certifications' ? 'selected' : '' }}>Certifications</option>
                        <option value="Excellent Communication Skills" {{ $job->requirements == 'Excellent Communication Skills' ? 'selected' : '' }}>Excellent Communication Skills</option>
                    </select>
                </div>
                    <div class="mb-3">
                        <label for="jobSalaryMin" class="form-label">Salary Min</label>
                        <input type="number" class="form-control" id="jobSalaryMin" name="salary_min" value="{{ $job->salary_min ?? '' }}" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="jobSalaryMax" class="form-label">Salary Max</label>
                        <input type="number" class="form-control" id="jobSalaryMax" name="salary_max" value="{{ $job->salary_max ?? '' }}" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="jobDeadline" class="form-label">Application Deadline</label>
                        <input type="date" class="form-control" id="jobDeadline" name="application_deadline" value="{{ $job->application_deadline }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Job</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($jobs as $job)
<div class="modal fade" id="viewJobModal-{{ $job->id }}" tabindex="-1" aria-labelledby="viewJobModalLabel-{{ $job->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewJobModalLabel-{{ $job->id }}">Job Details: {{ $job->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> {{ $job->title }}</p>
                <p><strong>Description:</strong> {{ $job->description }}</p>
                <p><strong>Requirements:</strong> {{ $job->requirements ?? 'N/A' }}</p>
                <p><strong>Location:</strong> {{ $job->location }}</p>
                <p><strong>Type:</strong> {{ $job->job_type }}</p>
                <p><strong>Salary Range:</strong> {{ $job->salary_min ? $job->salary_min . ' - ' . $job->salary_max : 'N/A' }}</p>
                <p><strong>Application Deadline:</strong> {{ $job->application_deadline}}</p>
                <p><strong>Status:</strong> {{ ucfirst($job->status) }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($jobs as $job)
<!-- Modal delete-->
<div class="modal fade" id="confirmDeleteModal-{{ $job->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete {{ $job->title }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('employer.delete_job', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/employer/manage_jobs.js') }}"></script>
</body>
</html>
