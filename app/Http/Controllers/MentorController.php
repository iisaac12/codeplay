<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\MentorForum;
use App\Models\MentorForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MentorController extends Controller
{
    // Dashboard mentor
    public function dashboard()
    {
        $courses = Course::where('mentor_id', Auth::id())
            ->withCount('enrollments')
            ->get();

        return view('mentor.dashboard', compact('courses'));
    }

    // CRUD Video/Materi
    public function createMaterial($courseId)
    {
        $course = Course::where('mentor_id', Auth::id())
            ->findOrFail($courseId);

        return view('mentor.materials.create', compact('course'));
    }

    public function storeMaterial(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|max:200',
            'type' => 'required|in:video,text,code,pdf',
            'content' => 'required_if:type,text,code',
            'file' => 'required_if:type,video,pdf|file|max:50000'
        ]);

        $fileUrl = null;
        if ($request->hasFile('file')) {
            $fileUrl = $request->file('file')->store('materials', 'public');
        }

        CourseMaterial::create([
            'course_id' => $courseId,
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            'content' => $request->input('content'),
            'file_url' => $fileUrl,
            'order_index' => $request->input('order_index', 0)
        ]);

        return redirect()->route('mentor.course.show', $courseId)
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    // Forum Mentor
    public function forumIndex()
    {
        $forums = MentorForum::with('mentor')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('mentor.forum.index', compact('forums'));
    }

    public function forumCreate()
    {
        return view('mentor.forum.create');
    }

    public function forumStore(Request $request)
    {
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
            'category' => 'required|in:tips,best_practice,discussion,question,announcement'
        ]);

        $forum = MentorForum::create([
            'mentor_id' => Auth::id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category' => $request->input('category')
        ]);

        return redirect()->route('mentor.forum.show', $forum->forum_id);
    }

    public function forumShow($forumId)
    {
        $forum = MentorForum::with(['mentor', 'replies.mentor'])
            ->findOrFail($forumId);

        // Increment view using DB query
        DB::table('mentor_forums')
            ->where('forum_id', $forumId)
            ->increment('view_count');

        return view('mentor.forum.show', compact('forum'));
    }

    public function forumReply(Request $request, $forumId)
    {
        $request->validate([
            'content' => 'required'
        ]);

        MentorForumReply::create([
            'forum_id' => $forumId,
            'mentor_id' => Auth::id(),
            'content' => $request->input('content')
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil ditambahkan!');
    }
}
