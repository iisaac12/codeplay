<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\UserEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // Redirect logic based on role...
        switch ($user->role) {
            case 'admin': return redirect()->route('admin.dashboard');
            case 'mentor': return redirect()->route('mentor.dashboard');
            default: return redirect()->route('user.dashboard');
        }
    }

    public function userDashboard(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Query Course (Filter & Search)
        $query = Course::where('is_published', true)
                       ->where('is_verified', true)
                       ->with('mentor', 'category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('level') && $request->level != '') {
            $query->where('level', $request->level);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query->paginate(12);
        $categories = Category::all();

        // --- PERBAIKAN DI SINI ---
        // Kita ambil data enrollment lengkap, lalu index-kan berdasarkan course_id
        // Supaya di view nanti bisa dipanggil: $enrollments[course_id]->progress_percentage
        $enrollments = UserEnrollment::where('user_id', $user->user_id)
            ->get()
            ->keyBy('course_id');

        // Kirim variabel $enrollments ke view (bukan $enrolledCourseIds lagi)
        return view('user.dashboard', compact('user', 'courses', 'categories', 'enrollments'));
    }
}