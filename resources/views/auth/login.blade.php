<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To EventRize - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <a href="{{ route('home') }}" class="brand-container" aria-label="EventRize Home">
            <img src="{{ asset('images/logo.png') }}"
         alt="EventRize Logo"
         class="brand-logo">
    <span>EVENTRIZE</span>
</a>

            <h2>Welcome To EventRize</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="abdillah.firman@gmail.com" required value="{{ old('email', 'abdillah.firman@gmail.com') }}">
                </div>

                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required value="password">
                </div>

                <div class="forgot-password-link">
                    <a href="{{ route('login') }}">forgot password</a>
                </div>

                <button type="submit" class="btn-signin">Sign In</button>

                <div class="signup-prompt">
                    Don’t have an account? <a href="{{ route('register') }}">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

