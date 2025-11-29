<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profil — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
    .container { max-width: 600px; margin: 40px auto; padding: 0 24px; }
    
    .card { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 32px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); }
    .card-title { font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #0f172a; }
    
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #334155; }
    .form-input { 
        width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; 
        font-size: 14px; transition: border 0.2s; outline: none; 
    }
    .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    
    .btn-primary { 
        background: #3b82f6; color: white; border: none; padding: 12px 24px; 
        border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; 
        transition: background 0.2s; 
    }
    .btn-primary:hover { background: #2563eb; }
    
    .btn-ghost { 
        display: block; text-align: center; margin-top: 16px; 
        text-decoration: none; color: #64748b; font-size: 14px; 
    }
    .btn-ghost:hover { color: #1e293b; }

    .file-input-wrapper { display: flex; align-items: center; gap: 16px; margin-top: 8px; }
    .preview-img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0; }
  </style>
</head>
<body class="bg-light">

  <main class="container">
    <div class="card">
        <h1 class="card-title">Edit Profil</h1>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="full_name" class="form-input" value="{{ old('full_name', $user->full_name) }}" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Avatar -->
            <div class="form-group">
                <label class="form-label">Foto Profil</label>
                <div class="file-input-wrapper">
                    @php
                        $avatarSrc = $user->avatar_url && file_exists(storage_path('app/public/' . $user->avatar_url)) 
                            ? asset('storage/' . $user->avatar_url) 
                            : 'https://ui-avatars.com/api/?name='.urlencode($user->full_name).'&background=3b82f6&color=fff&bold=true';
                    @endphp
                    <img src="{{ $avatarSrc }}" class="preview-img" id="imgPreview">
                    <input type="file" name="avatar" class="form-input" style="border:none; padding:0;" onchange="previewImage(event)">
                </div>
            </div>

            <hr style="border:0; border-top:1px solid #f1f5f9; margin: 24px 0;">
            <p style="font-size: 12px; color: #94a3b8; margin-bottom: 16px;">Biarkan kosong jika tidak ingin mengganti password.</p>

            <!-- Password Baru -->
            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-input" placeholder="Minimal 6 karakter">
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('profile.show') }}" class="btn-ghost">Batal</a>
        </form>
    </div>
  </main>

  <script>
    // Script simple buat preview gambar pas diupload
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imgPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
  </script>

</body>
</html>