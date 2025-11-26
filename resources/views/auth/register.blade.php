<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register — LearnCode</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-light">
  <main class="auth-split">
    <section class="auth-form card card-elevated">
      <a href="../index.html" class="brand mb-24">
        <img src="../assets/images/logo.png" alt="LearnCode Logo" class="logo" />
        <span class="brand-name">LearnCode</span>
      </a>
      <h1 class="h2">Create your account</h1>
      <p class="text-muted mb-24">Start learning to code today.</p>
      <form id="registerForm" novalidate>
        <div class="form-control">
          <label for="name">Name</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-user input-icon"></i>
            <input type="text" id="name" name="name" placeholder="Your full name" required />
          </div>
          <small class="error-msg" data-error-for="name"></small>
        </div>
        <div class="form-control">
          <label for="email">Email</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-envelope input-icon"></i>
            <input type="email" id="email" name="email" placeholder="you@example.com" required />
          </div>
          <small class="error-msg" data-error-for="email"></small>
        </div>
        <div class="form-control">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <i class="fa-solid fa-lock input-icon"></i>
            <input type="password" id="password" name="password" placeholder="8+ characters" required minlength="8" />
          </div>
          <small class="error-msg" data-error-for="password"></small>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
        <div class="form-foot">
          <p class="text-muted">Already have an account? <a href="login.html">Log in</a></p>
        </div>
      </form>
    </section>
    <section class="auth-visual">
      <div class="illustration card card-elevated">
        <i class="fa-solid fa-laptop-code illu-icon"></i>
        <h3>Learn by doing</h3>
        <p class="text-muted">Interactive code exercises and instant feedback.</p>
      </div>
    </section>
  </main>

  <script src="../assets/js/validation.js"></script>
</body>
</html>