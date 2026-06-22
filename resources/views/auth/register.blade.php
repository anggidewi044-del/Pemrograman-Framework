<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EventRize</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card register-card">
            <a href="{{ route('home') }}" class="brand-container" aria-label="EventRize Home">
            <img src="{{ asset('images/logo.png') }}"
            alt="EventRize Logo"
            class="brand-logo">
            <span>EVENTRIZE</span>
            </a>

            <h2>Register</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="abdillah firmansyah" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="abdillah.firman@gmail.com" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="password">password</label>
                        <span>8 karakter huruf, angka &amp; simbol</span>
                    </div>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-signin">Sign Up</button>

                <div class="signup-prompt">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

