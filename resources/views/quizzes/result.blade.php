<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hasil: {{ $attempt->quiz->title }} — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; }
    

    .quiz-header { 
        background: white; border-bottom: 1px solid #e2e8f0; padding: 0 40px; 
        height: 70px; display: flex; align-items: center; justify-content: space-between; 
        position: sticky; top: 0; z-index: 50;
    }
    .brand-logo { font-size: 20px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; text-decoration: none; }
    
    
    .container { max-width: 800px; margin: 40px auto; padding: 0 24px; }

    
    .score-card { 
        background: white; border-radius: 24px; padding: 40px; text-align: center; 
        border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); 
        margin-bottom: 32px; overflow: hidden; position: relative;
    }
    
    
    .result-icon { 
        width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 24px; 
        display: flex; align-items: center; justify-content: center; font-size: 32px; 
    }
    .pass .result-icon { background: #dcfce7; color: #166534; }
    .fail .result-icon { background: #fee2e2; color: #991b1b; }
    
    .score-value { font-size: 48px; font-weight: 800; line-height: 1; margin-bottom: 8px; color: #0f172a; }
    .score-label { font-size: 14px; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
    
    .status-badge { 
        display: inline-block; padding: 6px 16px; border-radius: 99px; 
        font-weight: 700; font-size: 14px; margin-bottom: 24px; 
    }
    .pass .status-badge { background: #dcfce7; color: #15803d; }
    .fail .status-badge { background: #fee2e2; color: #b91c1c; }

    
    .stats-grid { 
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; 
        margin-top: 32px; padding-top: 32px; border-top: 1px solid #f1f5f9; 
    }
    .stat-item { text-align: center; }
    .stat-val { font-weight: 700; font-size: 18px; color: #334155; }
    .stat-lbl { font-size: 12px; color: #94a3b8; margin-top: 4px; }

    
    .section-title { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    
    .review-card { 
        background: white; border: 1px solid #e2e8f0; border-radius: 12px; 
        padding: 24px; margin-bottom: 16px; position: relative; overflow: hidden;
    }
    .review-card.correct { border-left: 4px solid #22c55e; }
    .review-card.wrong { border-left: 4px solid #ef4444; }
    
    .q-text { font-weight: 600; font-size: 16px; margin-bottom: 16px; color: #1e293b; }
    
    .answer-box { 
        background: #f8fafc; padding: 12px 16px; border-radius: 8px; 
        font-size: 14px; color: #475569; display: flex; justify-content: space-between; align-items: center;
        margin-top: 8px;
    }
    .answer-box.user-correct { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .answer-box.user-wrong { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .answer-box.correct-key { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; margin-top: 8px; }

    
    .action-bar { display: flex; gap: 16px; margin-top: 40px; justify-content: center; }
    
    .btn { 
        padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; 
        cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; 
        transition: transform 0.1s; border: none;
    }
    .btn:active { transform: scale(0.98); }
    
    .btn-primary { background: #3b82f6; color: white; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3); }
    .btn-primary:hover { background: #2563eb; }
    
    .btn-outline { background: white; border: 1px solid #cbd5e1; color: #475569; }
    .btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; }
  </style>
</head>
<body>

  
  <header class="quiz-header">
    <a href="{{ route('dashboard') }}" class="brand-logo">
      <span style="background: #3b82f6; color: white; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 14px;">CP</span>
      CodePlay
    </a>
    <div style="font-size: 14px; color: #64748b;">
        Selesai pada {{ $attempt->submitted_at ? $attempt->submitted_at->format('d M Y, H:i') : now()->format('d M Y') }}
    </div>
  </header>

  <main class="container">
    
    
    
    <div class="score-card {{ $attempt->is_passed ? 'pass' : 'fail' }}">
        
        <div class="result-icon">
            @if($attempt->is_passed)
                <i class="fa-solid fa-trophy"></i>
            @else
                <i class="fa-solid fa-face-frown-open"></i>
            @endif
        </div>

        <div class="status-badge">
            {{ $attempt->is_passed ? 'LULUS / PASSED' : 'BELUM LULUS / FAILED' }}
        </div>

        <div class="score-value">{{ round($attempt->score) }}</div>
        <div class="score-label">dari Total {{ $attempt->max_score }} Poin</div>

        <p style="margin-top: 16px; color: #64748b;">
            @if($attempt->is_passed)
                Selamat! Anda telah menguasai materi ini dengan baik.
            @else
                Jangan menyerah! Pelajari materi lagi dan coba kuis ini kembali.
            @endif
        </p>

        
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-val">{{ gmdate('i:s', $attempt->time_taken) }}</div>
                <div class="stat-lbl">Waktu Pengerjaan</div>
            </div>
            <div class="stat-item">
                <div class="stat-val" style="color: #22c55e;">
                    {{ $attempt->answers->where('is_correct', true)->count() }}
                </div>
                <div class="stat-lbl">Jawaban Benar</div>
            </div>
            <div class="stat-item">
                <div class="stat-val" style="color: #ef4444;">
                    {{ $attempt->answers->where('is_correct', false)->count() }}
                </div>
                <div class="stat-lbl">Jawaban Salah</div>
            </div>
        </div>
    </div>

    
    <div class="action-bar">
        
        <a href="{{ route('course.show', $attempt->quiz->course->slug ?? '#') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Materi
        </a>

        
        <form action="{{ route('quiz.start', $attempt->quiz_id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-rotate-right"></i> Coba Lagi
            </button>
        </form>
    </div>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 40px 0;">

    
    <div>
        <h3 class="section-title"><i class="fa-solid fa-list-check"></i> Detail Jawaban</h3>

        @foreach($attempt->answers as $answer)
            <div class="review-card {{ $answer->is_correct ? 'correct' : 'wrong' }}">
                
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                    <div class="q-text">
                        {{ $loop->iteration }}. {!! nl2br(e($answer->question->question_text)) !!}
                    </div>
                    <span style="font-size: 12px; font-weight: 700; padding: 4px 8px; border-radius: 4px; background: {{ $answer->is_correct ? '#dcfce7' : '#fee2e2' }}; color: {{ $answer->is_correct ? '#166534' : '#991b1b' }}; white-space: nowrap;">
                        {{ $answer->points_earned }} / {{ $answer->question->points }} Poin
                    </span>
                </div>

                
                <div class="answer-box {{ $answer->is_correct ? 'user-correct' : 'user-wrong' }}">
                    <span>
                        <strong>Jawaban Anda:</strong> 
                        @if($answer->question->question_type === 'multiple_choice')
                            {{ $answer->selectedOption->option_text ?? 'Tidak dijawab' }}
                        @else
                            {{ $answer->answer_text ?? 'Tidak dijawab' }} (Coding)
                        @endif
                    </span>
                    @if($answer->is_correct)
                        <i class="fa-solid fa-check-circle"></i>
                    @else
                        <i class="fa-solid fa-circle-xmark"></i>
                    @endif
                </div>

                
                @if(!$answer->is_correct && $answer->question->question_type === 'multiple_choice')
                    @php
                        $correctOption = $answer->question->options->where('is_correct', true)->first();
                    @endphp
                    @if($correctOption)
                        <div class="answer-box correct-key">
                            <span><strong>Kunci Jawaban:</strong> {{ $correctOption->option_text }}</span>
                            <i class="fa-solid fa-key"></i>
                        </div>
                    @endif
                @endif

            </div>
        @endforeach

    </div>

  </main>

</body>
</html>