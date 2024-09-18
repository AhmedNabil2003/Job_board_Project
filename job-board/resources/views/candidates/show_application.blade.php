<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">My Applications</h2>
                        <ul class="list-group">
                            @foreach ($applications as $application)
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#applicationModal-{{ $application->id }}">
                                      View Application 
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('candidate.dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
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
                        <p><strong>Email:</strong> {{ $application->email }}</p>
                        <p><strong>Phone:</strong> {{ $application->phone }}</p>
                        <p><strong>Resume:</strong> <a href="{{ asset('storage/' . $application->resume) }}" target="_blank">View Resume</a></p>
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
