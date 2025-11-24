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
        $query = Course::where('is_published', true)
                      ->where('is_verified', true)
                      ->with('mentor', 'category');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by level
        if ($request->has('level') && $request->level != '') {
            $query->where('level', $request->level);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query->paginate(12);
        $categories = Category::all();

        // Get user enrolled courses
        $enrolledCourseIds = [];
        if (Auth::check()) {
            $enrolledCourseIds = UserEnrollment::where('user_id', Auth::id())
                ->pluck('course_id')
                ->toArray();
        }

        return view('dashboard', compact('courses', 'categories', 'enrolledCourseIds'));
    }
}
