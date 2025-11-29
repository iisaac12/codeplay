
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Materials — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-light">
  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('user.dashboard') }}" class="brand">
      <img src="{{ asset('assets/logo.svg') }}" class="logo">
     <span class="brand-name">CodePlay</span>
      </a>
      <nav class="app-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-link">Courses</a>
        <a href="{{ route('materials.index') }}" class="nav-link">Materials</a>
        <a href="{{ route('progress.index')}}" class="nav-link">Progress</a>
         <a href="{{ route('forum.index')}}" class="nav-link">Forum</a>

    </nav>
      <div class="profile">
        <img src="https://i.pravatar.cc/40?img=5" alt="Profile" class="avatar" />
        <div class="profile-info">
          <span class="name">Alex</span>
          <span class="role text-muted">Student</span>
        </div>
      </div>
    </div>
  </header>

  <main class="container">
    <section class="card">
      <h1 class="h3">Course materials</h1>
      <ul class="materials-list">
        <li class="material-item card">
          <div class="material-info">
            <i class="fa-regular fa-file-pdf material-icon"></i>
            <div>
              <strong>JavaScript Cheat Sheet (PDF)</strong>
              <p class="text-muted">Quick reference for syntax and patterns.</p>
            </div>
          </div>
          <button class="btn btn-outline" data-download>Download</button>
        </li>
        <li class="material-item card">
          <div class="material-info">
            <i class="fa-solid fa-video material-icon"></i>
            <div>
              <strong>CSS Flexbox Guide (Video)</strong>
              <p class="text-muted">Visual walkthrough of flex properties.</p>
            </div>
          </div>
          <button class="btn btn-outline" data-download>Download</button>
        </li>
        <li class="material-item card">
          <div class="material-info">
            <i class="fa-regular fa-file-lines material-icon"></i>
            <div>
              <strong>HTML Semantics (Notes)</strong>
              <p class="text-muted">Best practices for accessible markup.</p>
            </div>
          </div>
          <button class="btn btn-outline" data-download>Download</button>
        </li>
      </ul>
    </section>

    <div class="toast" id="toast">
      <i class="fa-solid fa-check text-success"></i>
      <span>Download successful</span>
    </div>
  </main>

  <script>
    const btns = document.querySelectorAll('[data-download]');
    const toast = document.getElementById('toast');
    btns.forEach(b => {
      b.addEventListener('click', () => {
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2000);
      });
    });
  </script>
</body>
</html>
