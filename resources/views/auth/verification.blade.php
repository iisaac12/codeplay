<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Verify your email — LearnCode</title>
  
  {{-- Gunakan Vite untuk meload CSS/JS utama --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Jika masih pakai CSS manual di folder public/assets --}}
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-soft-blue">
  <main class="verify-wrap" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <section class="card card-elevated verify-card text-center p-5 shadow">
      
      <div class="verify-icon mb-4" style="font-size: 3rem; color: #4F46E5;">
        <i class="fa-solid fa-envelope-open-text"></i>
      </div>
      
      <h1 class="h2 mb-3">Check your inbox</h1>
      <p class="text-muted mb-4">
        We’ve sent a verification link to your email address.<br>
        Please click the link to activate your account.
      </p>
      
      <div class="verify-actions d-flex flex-column gap-2 justify-content-center">
        {{-- Tombol Buka Aplikasi Email --}}
        <a href="mailto:" class="btn btn-primary w-100 mb-2">Open email app</a>
        
        {{-- Tombol Resend (Sementara dimatikan atau arahkan ke # dulu karena belum ada fungsi resend) --}}
        {{-- <form action="#" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline w-100">Resend email</button>
        </form> --}}
        
        {{-- Tombol Balik ke Login --}}
        <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 mt-2" style="text-decoration: none; color: gray;">
            Back to Login
        </a>
      </div>

    </section>
  </main>
</body>
</html>