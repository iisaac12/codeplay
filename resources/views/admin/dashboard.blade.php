@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
        <header class="app-header">
        <div class="container">
            <div class="app-header-inner">
                <div class="brand">
                    <span style="font-size: 24px;">🏠</span>
                    <span style="background: var(--danger); color: var(--white); width: 24px; height: 24px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">Q</span>
                    <span class="brand-name">Admin Dashboard</span>
                </div>
                
                <div class="profile">
                    <span class="text-muted">Administrator</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-ghost" style="padding: 8px 12px;">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

        <main style="background: var(--bg); min-height: calc(100vh - 80px); padding: 32px 0;">
        <div class="container">
                        <div class="welcome">
                <div>
                    <h1 class="h2">Dashboard Admin</h1>
                    <p class="text-muted">Lanjutkan perjalanan belajar coding Anda hari ini</p>
                </div>
            </div>

                        <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
                                <div class="card card-elevated">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <span style="font-size: 32px;">👥</span>
                        <div>
                            <div class="stat-number">{{ $totalUsers }}</div>
                            <div class="text-muted" style="font-size: 14px;">Total Pengguna</div>
                        </div>
                    </div>
                </div>

                                <div class="card card-elevated">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <span style="font-size: 32px; color: var(--success);">✓</span>
                        <div>
                            <div class="stat-number">{{ $totalUsers - $pendingUsers }}</div>
                            <div class="text-muted" style="font-size: 14px;">Terverifikasi</div>
                        </div>
                    </div>
                </div>

                                <div class="card card-elevated">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <span style="font-size: 32px;">📚</span>
                        <div>
                            <div class="stat-number">{{ $totalCourses }}</div>
                            <div class="text-muted" style="font-size: 14px;">Total Kursus</div>
                        </div>
                    </div>
                </div>

                                <div class="card card-elevated">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <span style="font-size: 32px; color: var(--danger);">⊗</span>
                        <div>
                            <div class="stat-number">{{ $pendingUsers + $pendingCourses }}</div>
                            <div class="text-muted" style="font-size: 14px;">Pending Review</div>
                        </div>
                    </div>
                </div>
            </div>

                        <div style="margin: 24px 0;">
                <div class="input-with-icon">
                    <span class="input-icon">🔍</span>
                    <input type="text" placeholder="Cari Pengguna atau kursus..." id="searchInput">
                </div>
            </div>

                        <div style="display: flex; gap: 16px; border-bottom: 2px solid #E5E7EB; margin-bottom: 24px;">
                <button class="btn-ghost" id="tabUsers" style="border-bottom: 3px solid var(--primary); padding-bottom: 12px; font-weight: 700;">
                    Manajemen Pengguna
                </button>
                <button class="btn-ghost" id="tabCourses" style="padding-bottom: 12px;">
                    Manajemen Kursus
                </button>
            </div>

            <div id="usersSection">
                <div class="card card-elevated">
                    <div class="card-header">
                        <h3 class="h4">Daftar Pengguna</h3>
                    </div>

                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Kursus</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td style="font-weight: 600;">{{ $user->full_name }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'pelajar')
                                            <span class="tag" style="background: #EEF2F6;">Pelajar</span>
                                        @elseif($user->role === 'mentor')
                                            <span class="tag" style="background: #1F2937; color: var(--white);">Mentor</span>
                                        @else
                                            <span class="tag" style="background: var(--primary); color: var(--white);">Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->is_verified)
                                            <span class="tag success" style="display: inline-flex; align-items: center; gap: 4px;">
                                                <span style="width: 6px; height: 6px; background: var(--success); border-radius: 50%; display: inline-block;"></span>
                                                Verified
                                            </span>
                                        @else
                                            <span class="tag" style="background: #FEF3C7; color: #D97706; display: inline-flex; align-items: center; gap: 4px;">
                                                <span style="width: 6px; height: 6px; background: #D97706; border-radius: 50%; display: inline-block;"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $user->enrollments->count() }}</td>
                                    <td>
                                        @if(!$user->is_verified)
                                            <form action="{{ route('admin.user.verify', $user->user_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <form action="{{ route('admin.user.verify', ['id' => $user->user_id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin memverifikasi user ini?');">
                                                        @csrf
                                        <button type="submit" class="btn" style="padding: 6px 12px; font-size: 12px; background: var(--success); color: var(--white); border: none;">
                                                Verifikasi
                                                </button>
                                                    </form>
                                            </form>
                                        @endif
                                        
                                        @if($user->is_active && $user->user_id !== auth()->id())
                                    <button class="btn" 
                                        style="padding: 6px 12px; font-size: 12px; background: var(--danger); color: var(--white); border: none;" 
                                            onclick="confirmDelete('{{ route('admin.user.delete', $user->user_id) }}', '{{ $user->full_name }}')">
                                                Delete
                                                    </button>                                                
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 32px; color: var(--text-muted);">
                                        Tidak ada data pengguna
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

                        <div id="coursesSection" style="display: none;">
                <div class="card card-elevated">
                    <div class="card-header">
                        <h3 class="h4">Daftar Kursus</h3>
                    </div>

                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul Kursus</th>
                                    <th>Mentor</th>
                                    <th>Kategori</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Peserta</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <td style="font-weight: 600;">{{ $course->title }}</td>
                                    <td class="text-muted">{{ $course->mentor->full_name }}</td>
                                    <td>
                                        <span class="tag">{{ $course->category->name }}</span>
                                    </td>
                                    <td>
                                        @if($course->level === 'beginner')
                                            <span class="tag success">Beginner</span>
                                        @elseif($course->level === 'intermediate')
                                            <span class="tag" style="background: #FEF3C7; color: #D97706;">Intermediate</span>
                                        @else
                                            <span class="tag" style="background: #FEE2E2; color: #DC2626;">Advanced</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($course->is_verified)
                                            <span class="tag success">✓ Verified</span>
                                        @else
                                            <span class="tag" style="background: #FEF3C7; color: #D97706;">⊗ Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $course->enrollments->count() }}</td>
                                    <td>
                                        @if(!$course->is_verified)
                                            <form action="{{ route('admin.course.verify', $course->course_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <form action="{{ route('admin.course.verify', ['id' => $course->course_id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin memverifikasi kursus ini?');">
                                                    @csrf
                                                    <button type="submit" class="btn" style="padding: 6px 12px; font-size: 12px; background: var(--success); color: var(--white); border: none;">
                                                        Verifikasi
                                                    </button>
                                                </form>
                                            </form>
                                        @endif
                                        
                                        <button class="btn" 
                                                style="padding: 6px 12px; font-size: 12px; background: var(--danger); color: var(--white); border: none;" 
                                                    onclick="confirmDelete('{{ route('admin.user.delete', $user->user_id) }}', '{{ $user->full_name }}')">
                                                        Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 32px; color: var(--text-muted);">
                                        Tidak ada data kursus
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

        <div class="modal" id="confirmModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="h4">Konfirmasi Hapus</h3>
                <button class="modal-close" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">Apakah Anda yakin ingin menghapus <strong id="itemName"></strong>?</p>
            </div>
            <div class="modal-footer" style="display: flex; gap: 8px; justify-content: flex-end; border-top: 1px solid #E5E7EB;">
                <button class="btn btn-ghost" onclick="closeModal()">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: var(--danger); color: var(--white); border: none;">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

        <div class="toast" id="toast">
        <span>✓</span>
        <span id="toastMessage">Aksi berhasil dilakukan!</span>
    </div>

    <script>

        const tabUsers = document.getElementById('tabUsers');
        const tabCourses = document.getElementById('tabCourses');
        const usersSection = document.getElementById('usersSection');
        const coursesSection = document.getElementById('coursesSection');

        tabUsers.addEventListener('click', () => {
            tabUsers.style.borderBottom = '3px solid var(--primary)';
            tabUsers.style.fontWeight = '700';
            tabCourses.style.borderBottom = 'none';
            tabCourses.style.fontWeight = '400';
            usersSection.style.display = 'block';
            coursesSection.style.display = 'none';
        });

        tabCourses.addEventListener('click', () => {
            tabCourses.style.borderBottom = '3px solid var(--primary)';
            tabCourses.style.fontWeight = '700';
            tabUsers.style.borderBottom = 'none';
            tabUsers.style.fontWeight = '400';
            coursesSection.style.display = 'block';
            usersSection.style.display = 'none';
        });


        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const activeTable = usersSection.style.display !== 'none' ? 
                usersSection.querySelector('tbody') : 
                coursesSection.querySelector('tbody');
            
            const rows = activeTable.querySelectorAll('tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });


        function confirmDelete(url, name) {
    const modal = document.getElementById('confirmModal');
    const itemName = document.getElementById('itemName');
    const deleteForm = document.getElementById('deleteForm');
    
    itemName.textContent = name;
    
    deleteForm.action = url;
    
    modal.classList.add('open');
}

        function closeModal() {
            document.getElementById('confirmModal').classList.remove('open');
        }


        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }


        @if(session('success'))
            showToast("{{ session('success') }}");
        @endif

        @if(session('error'))
            showToast("{{ session('error') }}");
        @endif
    </script>
</body>
</html>