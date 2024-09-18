<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/sgin/register.css') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/register.js') }}"></script> 
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="register-modal">
        <h5>Register</h5>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="d-flex justify-content-between mb-3">
                <button type="button" class="btn role-btn" data-role="employer">Employer</button>
                <button type="button" class="btn role-btn" data-role="candidate">Candidate</button>
                <button type="button" class="btn role-btn" data-role="admin">Admin</button>
            </div>
            <input type="hidden" name="role" id="selected-role" required>

            <div class="form-group position-relative">
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
            <div class="form-group position-relative">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <span class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" id="toggle-password">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="form-group position-relative">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                <span class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" id="toggle-password-confirm">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-light">Already have an account? Login</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
