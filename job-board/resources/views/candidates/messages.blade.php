<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">My Messages</h2>
                        <ul class="list-group">
                            @forelse ($messages as $message)
                                <li class="list-group-item">
                                    <h5>{{ $message->subject }}</h5>
                                    <p>{{ $message->message }}</p>
                                    <small class="text-muted">{{ $message->created_at->format('d M Y, h:i A') }}</small>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No messages found.
                                </li>
                            @endforelse
                        </ul>
                        <a href="{{ route('candidate.dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
