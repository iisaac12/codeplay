<?php
namespace App\Http\Controllers;

use App\Models\ForumThread;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    // List threads
    public function index($courseId = null)
    {
        $query = ForumThread::with(['user', 'course']);

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        $threads = $query->orderBy('is_pinned', 'desc')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(20);

        return view('forumUser', compact('threads', 'courseId'));
    }

    // Create thread
    public function create($courseId = null)
    {
        return view('forum.create', compact('courseId'));
    }

    // Store thread
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
            'course_id' => 'nullable|exists:courses,course_id'
        ]);

        $thread = ForumThread::create([
            'user_id' => Auth::id(),
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        return redirect()->route('forum.show', $thread->thread_id);
    }

    // Show thread
    public function show($threadId)
    {
        $thread = ForumThread::with(['user', 'course', 'replies.user'])
            ->findOrFail($threadId);

        // Increment view using DB query
        DB::table('forum_threads')
            ->where('thread_id', $threadId)
            ->increment('view_count');

        return view('forum.show', compact('thread'));
    }

    // Reply to thread
    public function reply(Request $request, $threadId)
    {
        $request->validate([
            'content' => 'required'
        ]);

        ForumReply::create([
            'thread_id' => $threadId,
            'user_id' => Auth::id(),
            'content' => $request->input('content')
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil ditambahkan!');
    }
}