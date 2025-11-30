<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['mentor', 'category', 'materials', 'tutorials', 'quizzes'])
            ->firstOrFail();

        $isEnrolled = false;
        $enrollment = null;
        if (Auth::check()) {
            $enrollment = UserEnrollment::where('user_id', Auth::id())
                ->where('course_id', $course->course_id)
                ->first();
            $isEnrolled = $enrollment !== null;
        }

        return view('courses.show', compact('course', 'isEnrolled', 'enrollment'));
    }

    public function enroll($courseId)
    {
        $enrollment = UserEnrollment::firstOrCreate([
            'user_id' => Auth::id(),
            'course_id' => $courseId
        ]);

        return redirect()->back()->with('success', 'Berhasil mendaftar ke kursus!');
    }

    public function learn($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['materials', 'tutorials.steps', 'quizzes.questions'])
            ->firstOrFail();

        $enrollment = UserEnrollment::where('user_id', Auth::id())
            ->where('course_id', $course->course_id)
            ->firstOrFail();

        return view('courses.learn', compact('course', 'enrollment'));
    }
}
