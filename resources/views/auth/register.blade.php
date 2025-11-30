<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register — Codeplay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-light">
  <main class="auth-split">
    <section class="auth-form card card-elevated">
      <a href="{{ url('/') }}" class="brand mb-24">
        <img src="{{ asset('assets/logo.svg') }}" class="logo">
        <span class="brand-name">CodePlay</span>
      </a>
      <h1 class="h2">Create your account</h1>
      <p class="text-muted mb-24">Start learning to code today.</p>

      @if($errors->any())
        <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
            <ul style="padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      <form action="{{ route('register') }}" method="POST">

        <div class="form-control">
          <label for="full_name">Full Name</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-user input-icon"></i>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Your full name" required />
          </div>
        </div>

        <div class="form-control">
            <label for="username">Username</label>
            <div class="input-with-icon">
              <i class="fa-solid fa-at input-icon"></i>
              <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Choose a username" required />
            </div>
        </div>

        <div class="form-control">
          <label for="email">Email</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-envelope input-icon"></i>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required />
          </div>
        </div>

        <div class="form-control">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-lock input-icon"></i>
            <input type="password" id="password" name="password" placeholder="8+ characters" required minlength="8" />
          </div>
        </div>

        <div class="form-control">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-with-icon">
              <i class="fa-solid fa-check-double input-icon"></i>
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" required />
            </div>
        </div>

        <input type="hidden" name="role" value="pelajar">

        <button type="submit" class="btn btn-primary w-100">Register</button>
        
        <div class="form-foot">
          <p class="text-muted">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </div>
      </form>
    </section>

    <section class="auth-visual">
      <div class="illustration card card-elevated">
        <i class="fa-solid fa-laptop-code illu-icon"></i>
        <h3>Learn by doing</h3>
        <p class="text-muted">Interactive code exercises and instant feedback.</p>
      </div>
    </section>
  </main>


</body>
</html>