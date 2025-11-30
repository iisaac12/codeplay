<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Courses — LearnCode</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-light">
  <header class="app-header">
    <div class="container app-header-inner">
      <a href="../index.html" class="brand">
        <img src="assets/images/logo.png" class="logo" alt="LearnCode" />
        <span class="brand-name">LearnCode</span>
      </a>
      <nav class="app-nav">
        <a href="course-list.html" class="nav-link active">Courses</a>
        <a href="materials.html" class="nav-link">Materials</a>
        <a href="progress.html" class="nav-link">Progress</a>
        <a href="forum.html" class="nav-link">Forum</a>
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
    <section class="filter-bar card">
      <div class="filter-group">
        <label for="category">Category</label>
        <select id="category" class="select">
          <option value="all">All</option>
          <option value="web">Web Development</option>
          <option value="data">Data</option>
          <option value="cs">Computer Science</option>
        </select>
      </div>
      <div class="filter-group">
        <label for="level">Level</label>
        <select id="level" class="select">
          <option value="all">All</option>
          <option value="beginner">Beginner</option>
          <option value="intermediate">Intermediate</option>
          <option value="advanced">Advanced</option>
        </select>
      </div>
    </section>

    <section class="courses-grid">
      
      <article class="course-card card card-elevated">
        <img src="https://images.unsplash.com/photo-1547658719-1dc3d6f87acc?q=80&w=600&auto=format&fit=crop" alt="Course" class="course-thumb" />
        <div class="course-content">
          <div class="course-top">
            <h3>Front-End Foundations</h3>
            <span class="level tag">Beginner</span>
          </div>
          <p class="text-muted">Build clean, responsive interfaces with HTML, CSS, and JS.</p>
          <div class="progress-wrap">
            <div class="progress-bar"><span class="progress" style="width: 0%"></span></div>
            <span class="progress-label">Not started</span>
          </div>
          <div class="card-actions">
            <a href="tutorial.html" class="btn btn-primary">Start learning</a>
          </div>
        </div>
      </article>

      <article class="course-card card card-elevated">
        <img src="https://images.unsplash.com/photo-1518779578993-ec3579fee39f?q=80&w=600&auto=format&fit=crop" alt="Course" class="course-thumb" />
        <div class="course-content">
          <div class="course-top">
            <h3>JavaScript Deep Dive</h3>
            <span class="level tag">Advanced</span>
          </div>
          <p class="text-muted">Scopes, closures, async patterns, and performance tips.</p>
          <div class="progress-wrap">
            <div class="progress-bar"><span class="progress" style="width: 20%"></span></div>
            <span class="progress-label">20% complete</span>
          </div>
          <div class="card-actions">
            <a href="tutorial.html" class="btn btn-primary">Continue learning</a>
          </div>
        </div>
      </article>
    </section>
  </main>

  <script src="../assets/js/main.js"></script>
</body>
</html>