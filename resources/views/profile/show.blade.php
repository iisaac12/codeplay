<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Saya — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
    
    .app-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 12px 0; }
    .container { max-width: 1000px; margin: 0 auto; padding: 0 24px; }
    .app-header-inner { display: flex; align-items: center; justify-content: space-between; }
    .brand { text-decoration: none; color: #1e293b; font-weight: 800; font-size: 20px; display: flex; align-items: center; gap: 8px; }
    
    .profile-card {
        background: white; border-radius: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0; overflow: hidden; max-width: 600px; margin: 40px auto;
        text-align: center; padding-bottom: 32px;
    }
    
    .profile-header-bg {
        height: 120px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        margin-bottom: 60px; position: relative;
    }
    
    .profile-avatar-wrapper {
        position: absolute; left: 50%; bottom: -50px; transform: translateX(-50%);
        width: 100px; height: 100px; border-radius: 50%; border: 4px solid white;
        background: white; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    
    .profile-avatar { width: 100%; height: 100%; object-fit: cover; }
    
    .user-name { font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
    .user-email { color: #64748b; font-size: 14px; margin-bottom: 8px; }
    .user-role { 
        display: inline-block; background: #eff6ff; color: #3b82f6; 
        font-size: 12px; font-weight: 600; padding: 4px 12px; 
        border-radius: 99px; text-transform: uppercase; letter-spacing: 0.5px;
    }

    .info-list {
        margin: 32px 0; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9;
        text-align: left;
    }
    
    .info-item {
        padding: 16px 32px; border-bottom: 1px solid #f1f5f9;
        display: flex; justify-content: space-between; align-items: center;
    }
    .info-item:last-child { border-bottom: none; }
    .info-label { color: #64748b; font-size: 14px; font-weight: 500; }
    .info-value { color: #1e293b; font-weight: 600; font-size: 14px; }

    .action-buttons { display: flex; gap: 12px; justify-content: center; padding: 0 32px; }
    
    .btn { 
        padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; 
        cursor: pointer; text-decoration: none; border: none; flex: 1;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: transform 0.1s;
    }
    .btn:active { transform: scale(0.98); }
    
    .btn-edit { background: white; border: 1px solid #cbd5e1; color: #1e293b; }
    .btn-edit:hover { background: #f8fafc; border-color: #94a3b8; }
    
    .btn-logout { background: #fee2e2; color: #991b1b; }
    .btn-logout:hover { background: #fecaca; }

    .back-btn { margin: 24px 0; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #64748b; font-weight: 500; font-size: 14px; }
    .back-btn:hover { color: #1e293b; }
  </style>
</head>
<body class="bg-light">

  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo" style="width:40px;">
        <span class="brand-name">CodePlay</span>
      </a>
    </div>
  </header>

  <main class="container">
    
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <div class="profile-card">
        
        <div class="profile-header-bg">
            <div class="profile-avatar-wrapper">
                @php
                    $avatarSrc = $user->avatar_url && file_exists(storage_path('app/public/' . $user->avatar_url)) 
                        ? asset('storage/' . $user->avatar_url) 
                        : 'https://ui-avatars.com/api/?name='.urlencode($user->full_name).'&background=3b82f6&color=fff&bold=true';
                @endphp
                <img src="{{ $avatarSrc }}" alt="Profile" class="profile-avatar">
            </div>
        </div>

        <h1 class="user-name">{{ $user->full_name }}</h1>
        <p class="user-email">{{ $user->email }}</p>
        <span class="user-role">{{ ucfirst($user->role) }}</span>

        <div class="info-list">
            <div class="info-item">
                <span class="info-label"><i class="fa-regular fa-calendar me-2"></i> Bergabung Sejak</span>
                <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label"><i class="fa-solid fa-user-tag me-2"></i> Username</span>
                <span class="info-value">{{ $user->username }}</span>
            </div>
            <div class="info-item">
                <span class="info-label"><i class="fa-solid fa-envelope me-2"></i> Status Email</span>
                <span class="info-value" style="color: {{ $user->is_verified ? '#16a34a' : '#ea580c' }}">
                    {{ $user->is_verified ? 'Terverifikasi' : 'Belum Verifikasi' }}
                </span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('profile.edit') }}" class="btn btn-edit">
                <i class="fa-solid fa-pen-to-square"></i> Edit Profil
            </a>

            <form action="{{ route('logout') }}" method="POST" style="flex: 1;">
                @csrf
                <button type="submit" class="btn btn-logout" style="width: 100%;" onclick="return confirm('Yakin ingin keluar?')">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>

    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  @if(session('success'))
  <script>
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
    });
  </script>
  @endif

</body>
</html>