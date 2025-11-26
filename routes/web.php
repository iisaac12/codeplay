    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\CourseController;
    use App\Http\Controllers\MaterialController;
    use App\Http\Controllers\TutorialController;
    use App\Http\Controllers\QuizController;
    use App\Http\Controllers\ForumController;
    use App\Http\Controllers\MentorController;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\ProgressController;

    // Auth Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verification');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/email/verify-sent', [AuthController::class, 'showVerifyNotice'])->name('verification.notice');
    // Protected Routes
    //Route::middleware('auth')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboardUser',  [DashboardController::class, 'userDashboard'])->name('dashboard.user');
        
        // Courses
        Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
        Route::post('/course/{id}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');
        Route::get('/course/{slug}/learn', [CourseController::class, 'learn'])->name('course.learn');
        
        // Materials
        Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
        Route::get('/material/{id}', [MaterialController::class, 'show'])->name('material.show');
        Route::post('/material/{id}/progress', [MaterialController::class, 'updateProgress'])->name('material.progress');
        Route::get('/material/{id}/download', [MaterialController::class, 'download'])->name('material.download');
        
        // Tutorials
        Route::get('/tutorial/{id}', [TutorialController::class, 'show'])->name('tutorial.show');
        Route::get('/tutorial/step/{id}', [TutorialController::class, 'showStep'])->name('tutorial.step');
        Route::post('/tutorial/step/{id}/submit', [TutorialController::class, 'submitCode'])->name('tutorial.submit');
        
        // Quizzes
        Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
        Route::post('/quiz/{id}/start', [QuizController::class, 'start'])->name('quiz.start');
        Route::post('/quiz/attempt/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
        Route::get('/quiz/result/{id}', [QuizController::class, 'result'])->name('quiz.result');
        
        // Forum
        Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
        Route::get('/forum/course/{id}', [ForumController::class, 'index'])->name('forum.course');
        Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
        Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
        Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
        Route::post('/forum/{id}/reply', [ForumController::class, 'reply'])->name('forum.reply');
        
        // Progress
        Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
        
        // Mentor Routes
        Route::prefix('mentor')->name('mentor.')->middleware('role:mentor')->group(function () {
            Route::get('/dashboard', [MentorController::class, 'dashboard'])->name('dashboard');
            Route::get('/course/{id}/material/create', [MentorController::class, 'createMaterial'])->name('material.create');
            Route::post('/course/{id}/material', [MentorController::class, 'storeMaterial'])->name('material.store');
            
            // Mentor Forum
            Route::get('/forum', [MentorController::class, 'forumIndex'])->name('forumUser');
            Route::get('/forum/create', [MentorController::class, 'forumCreate'])->name('forum.create');
            Route::post('/forum', [MentorController::class, 'forumStore'])->name('forum.store');
            Route::get('/forum/{id}', [MentorController::class, 'forumShow'])->name('forum.show');
            Route::post('/forum/{id}/reply', [MentorController::class, 'forumReply'])->name('forum.reply');
        });
        
        // Admin Routes
        Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/verifications', [AdminController::class, 'pendingVerifications'])->name('verifications');
            Route::post('/user/{id}/verify', [AdminController::class, 'verifyUser'])->name('user.verify');
            Route::post('/course/{id}/verify', [AdminController::class, 'verifyCourse'])->name('course.verify');
        });
    //});