<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login — LearnCode</title>
  
  {{-- 1. Menggunakan Vite untuk CSS/JS --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-light">
  <main class="auth-center">
    <section class="card card-elevated auth-card">
      
      {{-- 2. Link Logo ke Homepage --}}
      <a href="{{ url('/') }}" class="brand mb-16">
        {{-- 3. Mengambil gambar menggunakan asset() --}}
        <img src="{{ asset('assets/logo.svg') }}" class="logo" />
        <span class="brand-name">CodePlay</span>
      </a>

      <h1 class="h3">Welcome back</h1>
      <p class="text-muted">Log in to continue learning.</p>

      {{-- 4. Menampilkan Pesan Error / Sukses dari Controller --}}
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

      {{-- 5. FORM UTAMA (Action & Method Penting!) --}}
      <form action="{{ route('login') }}" method="POST">
        
        {{-- 6. Token Keamanan Wajib --}}
        @csrf

        <div class="form-control">
          <label for="loginEmail">Email</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-envelope input-icon"></i>
            {{-- 7. Tambah value old('email') agar tidak ngetik ulang jika salah pass --}}
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
            {{-- Link forgot password (opsional jika belum ada routenya, beri #) --}}
            <a href="#" class="link">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">Log in</button>
      </form>

      <div class="auth-alt mt-16">
        {{-- 8. Link ke halaman Register --}}
        <p class="text-muted">New here? <a href="{{ route('register') }}">Create account</a></p>
      </div>
    </section>
  </main>
  
  {{-- Script validation bawaan kamu --}}
  <script src="{{ asset('assets/js/validation.js') }}"></script>
</body>
</html>