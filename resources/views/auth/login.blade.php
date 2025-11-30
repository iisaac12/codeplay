<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login — LearnCode</title>
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-light">
  <main class="auth-center">
    <section class="card card-elevated auth-card">
      
      <a href="{{ url('/') }}" class="brand mb-16">
        <img src="{{ asset('assets/logo.svg') }}" class="logo" />
        <span class="brand-name">CodePlay</span>
      </a>

      <h1 class="h3">Welcome back</h1>
      <p class="text-muted">Log in to continue learning.</p>

      @if(session('success'))
          <div class="alert alert-success" style="color: green; margin-bottom: 10px;">
              {{ session('success') }}
          </div>
      @endif

      @if($errors->any())
          <div class="alert alert-danger" style="color: red; margin-bottom: 10px;">
              <ul>
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ route('login') }}" method="POST">
        
        @csrf

        <div class="form-control">
          <label for="loginEmail">Email</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-envelope input-icon"></i>
            <input type="email" id="loginEmail" name="email" placeholder="you@example.com" value="{{ old('email') }}" required />
          </div>
        </div>

        <div class="form-control">
          <label for="loginPassword">Password</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-lock input-icon"></i>
            <input type="password" id="loginPassword" name="password" placeholder="Your password" required />
          </div>
        </div>

        <div class="form-inline">
            <a href="#" class="link">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">Log in</button>
      </form>

      <div class="auth-alt mt-16">
        <p class="text-muted">New here? <a href="{{ route('register') }}">Create account</a></p>
      </div>
    </section>
  </main>
  
  <script src="{{ asset('assets/js/validation.js') }}"></script>
</body>
</html>