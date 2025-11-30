<?php

namespace App\Http\Controllers;

use App\Models\ForumThread;
use App\Models\Category;
use App\Models\Course;
use App\Models\ForumReply; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); 

        $query = ForumThread::with(['user', 'course.category'])
            ->withCount('replies');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }


        if ($request->has('category') && $request->category != '') {
            $query->whereHas('course.category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }


        $threads = $query->orderBy('is_pinned', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);


        $categories = Category::all();


        return view('forum.index', compact('threads', 'categories', 'user'));
    }


    public function show($id)
    {
        $user = Auth::user();

        $thread = ForumThread::with(['user', 'replies.user', 'course'])
            ->withCount('replies')
            ->findOrFail($id);

        $thread->increment('view_count');


        return view('forum.show', compact('thread', 'user'));
    }


    public function create()
    {
        $user = Auth::user();
        
        $courses = Course::all();
        

        return view('forum.create', compact('courses', 'user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
            'course_id' => 'nullable|exists:courses,course_id'
        ]);

        ForumThread::create([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'title' => $request->title,
            'content' => $request->content,
            'is_pinned' => false,
            'view_count' => 0
        ]);

        return redirect()->route('forum.index')->with('success', 'Pertanyaan berhasil diposting!');
    }


    public function reply(Request $request, $id)
    {
        $request->validate(['content' => 'required']);

        ForumReply::create([
            'thread_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_solution' => false
        ]);

        return redirect()->back()->with('success', 'Balasan terkirim!');
    }
}