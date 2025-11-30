<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Learning: {{ $course->title }} — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    .learn-grid {
        display: grid;
        grid-template-columns: 350px 1fr; 
        gap: 24px;
        margin-top: 24px;
        align-items: start;
    }

    
    .curriculum-card {
        max-height: calc(100vh - 100px);
        overflow-y: auto; 
        position: sticky;
        top: 24px;
    }

    .module-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        margin: 16px 0 8px 0;
        letter-spacing: 0.5px;
    }

    .lesson-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        color: var(--text);
        border: 1px solid transparent;
        transition: all 0.2s;
        margin-bottom: 4px;
    }

    .lesson-item:hover {
        background-color: #F9FAFB;
        border-color: #E5E7EB;
    }

    .lesson-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #EEF2F6;
        border-radius: 6px;
        color: var(--text-muted);
        font-size: 14px;
    }

    .lesson-item.active {
        background-color: #EFF6FF; 
        border-color: var(--primary);
    }
    
    .lesson-item.active .lesson-icon {
        background-color: var(--primary);
        color: white;
    }

    @media (max-width: 900px) {
        .learn-grid { grid-template-columns: 1fr; }
        .curriculum-card { max-height: none; position: static; }
    }
  </style>
</head>
<body class="bg-light">

  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('user.dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo">
        <span class="brand-name">CodePlay</span>
      </a>
      <div class="nav">
        <a href="{{ route('user.dashboard') }}" class="btn btn-ghost btn-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Dashboard
        </a>
      </div>
    </div>
  </header>

  <main class="container mb-24">
    <div class="learn-grid">

        <aside class="curriculum-card card card-elevated">
            <h3 class="h3 mb-16">Curriculum</h3>
            
            <div class="mb-24">
                <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px;">
                    <span class="text-muted">Course Progress</span>
                    <strong> {{ $enrollment->progress_percentage }}%</strong>
                </div>
                <div class="progress-bar">
                    <span class="progress" style="width: {{ $enrollment->progress_percentage }}%"></span>
                </div>
            </div>

            @if($course->materials->count() > 0)
                <div class="module-title"><i class="fa-solid fa-book me-2"></i> Reading Materials</div>
                @foreach($course->materials as $material)
                    <a href="{{ route('materials.show', $material->material_id) }}" class="lesson-item">
                        <div class="lesson-icon"><i class="fa-regular fa-file-pdf"></i></div>
                        <div style="flex: 1;">
                            <div style="font-weight: 500; font-size: 14px;">{{ $material->title }}</div>
                            <small class="text-muted">Reading</small>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted" style="font-size: 12px;"></i>
                    </a>
                @endforeach
            @endif

            @if($course->tutorials->count() > 0)
                <div class="module-title mt-16"><i class="fa-solid fa-code me-2"></i> Practical Labs</div>
                @foreach($course->tutorials as $tutorial)
                    <a href="{{ route('tutorial.show', $tutorial->tutorial_id) }}" class="lesson-item">
                        <div class="lesson-icon"><i class="fa-solid fa-terminal"></i></div>
                        <div style="flex: 1;">
                            <div style="font-weight: 500; font-size: 14px;">{{ $tutorial->title }}</div>
                            <small class="text-muted">{{ $tutorial->steps->count() }} Steps</small>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted" style="font-size: 12px;"></i>
                    </a>
                @endforeach
            @endif

            @if($course->quizzes->count() > 0)
                <div class="module-title mt-16"><i class="fa-solid fa-clipboard-question me-2"></i> Quizzes</div>
                @foreach($course->quizzes as $quiz)
                    <a href="{{ route('quiz.show', $quiz->quiz_id) }}" class="lesson-item">
                        <div class="lesson-icon"><i class="fa-solid fa-puzzle-piece"></i></div>
                        <div style="flex: 1;">
                            <div style="font-weight: 500; font-size: 14px;">{{ $quiz->title }}</div>
                            <small class="text-muted">{{ $quiz->questions->count() }} Questions</small>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted" style="font-size: 12px;"></i>
                    </a>
                @endforeach
            @endif

        </aside>

        <section class="content-area">
            <div class="card card-elevated p-5 text-center" style="min-height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                
                <div style="width: 80px; height: 80px; background: #E8F0FC; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                    <i class="fa-solid fa-graduation-cap" style="font-size: 32px; color: var(--primary);"></i>
                </div>

                <h1 class="h2">Welcome to {{ $course->title }}</h1>
                <p class="text-muted" style="max-width: 500px; margin: 0 auto 24px;">
                    You are now enrolled! Select a lesson from the sidebar on the left to start your learning journey.
                </p>

                <div class="d-flex gap-3">
                    @if($firstMaterial = $course->materials->first())
                        <a href="{{ route('materials.show', $firstMaterial->material_id) }}" class="btn btn-primary btn-lg">
                            Start First Lesson <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    @elseif($firstTutorial = $course->tutorials->first())
                        <a href="{{ route('tutorial.show', $firstTutorial->id) }}" class="btn btn-primary btn-lg">
                            Start Coding <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled>No content yet</button>
                    @endif
                </div>

            </div>

            <div class="grid grid-cols-3 gap-4 mt-4" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 24px;">
                <div class="card p-3 text-center">
                    <div class="h3 text-primary">{{ $course->materials->count() }}</div>
                    <small class="text-muted">Materials</small>
                </div>
                <div class="card p-3 text-center">
                    <div class="h3 text-primary">{{ $course->tutorials->count() }}</div>
                    <small class="text-muted">Labs</small>
                </div>
                <div class="card p-3 text-center">
                    <div class="h3 text-primary">{{ $course->quizzes->count() }}</div>
                    <small class="text-muted">Quizzes</small>
                </div>
            </div>

        </section>

    </div>
  </main>

</body>
</html>