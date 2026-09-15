<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Yellow Achiever's Award</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body{min-height:100vh;display:flex;align-items:center;background:var(--navy,#0b1118)}
        .login-card{max-width:400px;width:100%;margin:0 auto;background:#fff;border-radius:12px;padding:40px;box-shadow:0 25px 60px rgba(0,0,0,.35)}
        .login-logo{width:150px;display:block;margin:0 auto 24px}
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <img class="login-logo" src="{{ asset('images/yellow-achievers-logo.webp') }}" alt="Yellow Achiever's Award">
            <h1 class="h4 text-center mb-4">Admin Sign In</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>
                <button type="submit" class="btn btn-gold w-100">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
