<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $quiz->title }} — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    
    .card-intro { 
        background: white; border: 1px solid #e2e8f0; border-radius: 16px; 
        padding: 40px; text-align: center; max-width: 600px; margin: 40px auto; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
    }
    
    .icon-wrapper {
        width: 80px; height: 80px; background: #eff6ff; color: #3b82f6;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 32px; margin: 0 auto 24px;
    }

    .info-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin: 32px 0;
        text-align: left;
    }
    
    .info-item {
        background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;
    }
    
    .info-label { font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
    .info-value { font-size: 16px; color: #1e293b; font-weight: 700; margin-top: 4px; }

    .btn-start {
        background: #3b82f6; color: white; border: none; padding: 14px 32px;
        border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer;
        width: 100%; transition: background 0.2s; display: inline-flex;
        align-items: center; justify-content: center; gap: 8px;
    }
    .btn-start:hover { background: #2563eb; }
  </style>
</head>
<body>


<header class="app-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 16px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
      <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #1e293b; font-weight: 700; font-size: 20px; display: flex; align-items: center; gap: 8px;">
        <span style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;">CP</span>
        <span>CodePlay</span>
      </a>
    </div>
  </header>

  <main style="padding: 0 24px;">
    
    <div class="card-intro">
        <div class="icon-wrapper">
            <i class="fa-solid fa-clipboard-question"></i>
        </div>

        <h1 style="font-size: 24px; font-weight: 800; color: #1e293b; margin-bottom: 8px;">
            {{ $quiz->title }}
        </h1>
        <p style="color: #64748b; font-size: 15px; line-height: 1.6;">
            {{ $quiz->description ?? 'Uji pemahaman Anda tentang materi ini dengan mengerjakan kuis berikut.' }}
        </p>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label"><i class="fa-regular fa-clock"></i> Durasi</div>
                <div class="info-value">{{ $quiz->time_limit ?? 30 }} Menit</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fa-solid fa-list-check"></i> Jumlah Soal</div>
                <div class="info-value">{{ $quiz->questions->count() }} Soal</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fa-solid fa-bullseye"></i> KKM (Passing Grade)</div>
                <div class="info-value">{{ $quiz->passing_score }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fa-solid fa-rotate-left"></i> Percobaan</div>
                <div class="info-value">Unlimited</div>
            </div>
        </div>

        
        
        <form action="{{ route('quiz.start', $quiz->quiz_id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-start">
                Mulai Kuis Sekarang <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
        
        <a href="{{ route('course.show', $quiz->course->slug ?? '#') }}" style="display: inline-block; margin-top: 16px; color: #64748b; text-decoration: none; font-size: 14px;">
            Batal, kembali ke materi
        </a>
    </div>

  </main>

</body>
</html>