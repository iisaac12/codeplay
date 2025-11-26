<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Akun</title>
</head>
<body>
    <h2>Halo, selamat datang di LearnCode!</h2>
    <p>Terima kasih telah mendaftar. Mohon verifikasi email Anda untuk mengaktifkan akun.</p>
    
    <p>
        {{-- Ini akan memanggil route 'verify.email' yang ada di web.php --}}
        <a href="{{ route('verification', $token) }}" style="background-color: #4F46E5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Verifikasi Akun Saya
        </a>
    </p>
    
    <p>Atau copy link ini ke browser Anda:</p>
    <p>{{ route('verification', $token) }}</p>
</body>
</html>