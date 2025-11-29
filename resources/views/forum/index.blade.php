<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forum — Codeplay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
      .search-box { position: relative; margin-bottom: 24px; }
      .search-input { width: 100%; padding: 12px 16px; padding-left: 40px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit; }
      .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
      
      .tag-active { background-color: #3b82f6 !important; color: white !important; }
      
      .pagination { display: flex; justify-content: center; margin-top: 32px; }
  </style>
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
        <a href="{{ route('forum.index')}}" class="nav-link active" style="color: #1e293b;">Forum</a>
      </nav>
      
      <a href="{{ route('forum.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Post question
      </a>
    </div>
  </header>

  <main class="container forum-wrap" style="display: grid; grid-template-columns: 250px 1fr; gap: 32px; margin-top: 32px;">
    
    <aside>
        <div class="card p-4" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0;">
            <h3 class="h5 mb-3" style="font-weight: 700;">Categories</h3>
            <ul class="tag-list" style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 8px;">
                <li>
                    <a href="{{ route('forum.index') }}" class="tag {{ !request('category') ? 'tag-active' : '' }}" style="text-decoration: none; display: inline-block; padding: 6px 12px; border-radius: 6px; background: #f1f5f9; color: #475569; font-size: 13px; font-weight: 500;">
                        All
                    </a>
                </li>
                @foreach($categories as $category)
                    <li>
                        <a href="{{ route('forum.index', ['category' => $category->name]) }}" 
                           class="tag {{ request('category') == $category->name ? 'tag-active' : '' }}"
                           style="text-decoration: none; display: inline-block; padding: 6px 12px; border-radius: 6px; background: #f1f5f9; color: #475569; font-size: 13px; font-weight: 500;">
                            {{ strtolower($category->name) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <section class="forum-threads">
        
        <form action="{{ route('forum.index') }}" method="GET" class="search-box">
            <input type="text" name="search" class="search-input" placeholder="Search discussions..." value="{{ request('search') }}">
        </form>

        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0;">
                {{ session('success') }}
            </div>
        @endif

        @forelse($threads as $thread)
            <article class="thread card card-elevated" style="margin-bottom: 16px; padding: 24px; background: white; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div class="thread-top">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <h3 class="h4" style="margin: 0 0 8px 0;">
                            <a href="{{ route('forum.show', $thread->thread_id) }}" style="text-decoration: none; color: #1e293b;">
                                @if($thread->is_pinned) <i class="fa-solid fa-thumbtack" style="color: #ef4444; margin-right: 6px;"></i> @endif
                                {{ $thread->title }}
                            </a>
                        </h3>
                    </div>
                    
                    <div class="thread-meta text-muted" style="font-size: 13px; display: flex; align-items: center; gap: 12px;">
                        <span>by <strong style="color: #334155;">{{ $thread->user->full_name }}</strong></span>
                        <span>• {{ $thread->created_at->diffForHumans() }}</span>
                        
                        @if($thread->course)
                            <span class="tag" style="background: #eff6ff; color: #3b82f6; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">
                                {{ $thread->course->category->name ?? 'General' }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <p style="color: #475569; line-height: 1.6; margin: 12px 0;">
                    {{ Str::limit($thread->content, 150) }}
                </p>
                
                <div class="thread-actions" style="display: flex; gap: 16px; border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: 12px;">
                    <a href="{{ route('forum.show', $thread->thread_id) }}" class="btn btn-ghost" style="color: #64748b; font-size: 13px; text-decoration: none;">
                        <i class="fa-regular fa-comment me-1"></i> {{ $thread->replies_count }} Replies
                    </a>
                    <span class="btn btn-ghost" style="color: #64748b; font-size: 13px;">
                        <i class="fa-regular fa-eye me-1"></i> {{ $thread->view_count }} Views
                    </span>
                </div>
            </article>
        @empty
            <div class="card p-5 text-center" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0;">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/no-data-found-8867280-7265556.png" style="width: 150px; opacity: 0.6; margin-left: 40%;">
                <h3 class="mt-3 text-muted">No discussions found</h3>
                <p class="text-muted" style="font-size: 14px;">Be the first to start a conversation!</p>
                <a href="{{ route('forum.create') }}" class="btn btn-primary mt-3">Start Discussion</a>
            </div>
        @endforelse

        <div class="pagination">
            {{ $threads->withQueryString()->links() }}
        </div>

    </section>
  </main>

</body>
</html>