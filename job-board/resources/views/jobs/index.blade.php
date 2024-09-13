<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
</head>
<body>
    <h2>قائمة الوظائف</h2>
    <ul>
        @foreach ($jobs as $job)
            <li>
                <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
            </li>
        @endforeach
    </ul>


</body>
</html>