@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mentor - CodePlay</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/components.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <style>
        .upload-area {
            border: 2px dashed #D0D5DD;
            border-radius: var(--radius);
            padding: 48px 24px;
            text-align: center;
            background: #F9FAFB;
            cursor: pointer;
            transition: all 0.3s;
        }
        .upload-area:hover {
            border-color: var(--primary);
            background: #F0F4F8;
        }
        .upload-area.drag-over {
            border-color: var(--primary);
            background: #E8F0FC;
        }
        .upload-icon {
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 16px;
        }
        .video-item {
            display: grid;
            grid-template-columns: 140px 1fr auto;
            gap: 16px;
            align-items: center;
            padding: 16px;
            background: var(--white);
            border: 1px solid #E5E7EB;
            border-radius: var(--radius);
            margin-bottom: 12px;
        }
        .video-thumb-wrapper {
            position: relative;
            width: 140px;
            height: 80px;
            border-radius: 10px;
            overflow: hidden;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .video-thumb-wrapper .video-icon {
            font-size: 32px;
            color: var(--white);
        }
        .video-info h4 {
            margin: 0 0 4px;
            font-size: 16px;
            font-weight: 600;
        }
        .video-meta {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
            font-size: 13px;
            color: var(--text-muted);
        }
        .video-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
            background: var(--white);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 18px;
        }
        .icon-btn:hover {
            background: #F9FAFB;
            box-shadow: var(--shadow-soft);
        }
        .icon-btn.delete {
            color: var(--danger);
        }
        .icon-btn.delete:hover {
            background: #FEE2E2;
        }
    </style>
</head>
<body>
    
    <header class="app-header">
        <div class="container">
            <div class="app-header-inner">
            <div class="brand">
                <a href="{{ route('mentor.dashboard') }}" style="text-decoration: none;">
                    <img src="{{ asset('assets/logo.svg') }}" alt="Logo" style="height: 40px;">
                </a>
                <span class="brand-name">Dashboard Mentor</span>
            </div>
                <div class="profile">
                    <span class="text-muted">{{ auth()->user()->full_name }}</span>
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
            
            <div style="margin-bottom: 32px;">
                <h1 class="h2" style="margin-bottom: 4px;">Selamat Datang, Mentor! 👨‍🏫</h1>
                <p class="text-muted">Kelola video pembelajaran dan bantu pelajar mencapai tujuan mereka</p>
            </div>

            
            <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 32px;">
                
                <div class="card card-elevated">
                    <div style="text-align: center;">
                        <span style="font-size: 40px; color: var(--primary);">🎥</span>
                        <div class="stat-number" style="margin-top: 8px;">{{ $totalVideos }}</div>
                        <div class="text-muted" style="font-size: 14px;">Total Video</div>
                    </div>
                </div>

                
                <div class="card card-elevated">
                    <div style="text-align: center;">
                        <span style="font-size: 40px; color: var(--success);">📤</span>
                        <div class="stat-number" style="margin-top: 8px;">{{ $publishedVideos }}</div>
                        <div class="text-muted" style="font-size: 14px;">Dipublikasi</div>
                    </div>
                </div>

                
                <div class="card card-elevated">
                    <div style="text-align: center;">
                        <span style="font-size: 40px;">👁️</span>
                        <div class="stat-number" style="margin-top: 8px;">{{ $totalViews }}</div>
                        <div class="text-muted" style="font-size: 14px;">Total Views</div>
                    </div>
                </div>

                
                <div class="card card-elevated">
                    <div style="text-align: center;">
                        <span style="font-size: 40px; color: #F59E0B;">📝</span>
                        <div class="stat-number" style="margin-top: 8px;">{{ $draftVideos }}</div>
                        <div class="text-muted" style="font-size: 14px;">Draft</div>
                    </div>
                </div>
            </div>

            
            <div class="card card-elevated">
                <div class="card-header" style="margin-bottom: 16px;">
                    <div>
                        <h3 class="h3" style="margin-bottom: 4px;">Manajemen Video Pembelajaran</h3>
                        <p class="text-muted" style="font-size: 14px;">Kelola konten video untuk kursus Anda</p>
                    </div>
                    <button class="btn btn-primary" onclick="openUploadModal()">
                        + Tambah Video Baru
                    </button>
                </div>

                
                <div style="margin-top: 24px;">
                    @forelse($materials as $material)
                    <div class="video-item">
                        
                        <div class="video-thumb-wrapper">
                            <span class="video-icon">▶</span>
                        </div>

                        
                        <div class="video-info">
                            <h4>{{ $material->title }}</h4>
                            <p class="text-muted" style="font-size: 13px; margin: 4px 0;">{{ $material->course->title }}</p>
                            
                            <div class="video-meta">
                                
                                @if($material->is_published ?? true)
                                    <span class="tag" style="background: #1F2937; color: var(--white);">Published</span>
                                @else
                                    <span class="tag" style="background: #E5E7EB; color: var(--text-muted);">Draft</span>
                                @endif

                                
                                <span>⏱️ Durasi: {{ gmdate('i:s', $material->duration ?? 0) }}</span>

                                
                                <span>👁️ Views: {{ $material->views ?? 0 }}</span>

                                
                                <span>📅 Upload: {{ $material->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>

                        
                        <div class="video-actions">
                            <a href="{{ route('mentor.material.edit', $material->material_id) }}" class="icon-btn" title="Edit">
                                ✏️
                            </a>
                            <button class="icon-btn delete" onclick="confirmDelete({{ $material->material_id }}, '{{ $material->title }}')" title="Hapus">
                                🗑️
                            </button>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 64px 24px;">
                        <span style="font-size: 64px;">📹</span>
                        <h3 class="h4" style="margin-top: 16px; color: var(--text-muted);">Belum Ada Video</h3>
                        <p class="text-muted">Mulai dengan menambahkan video pembelajaran pertama Anda!</p>
                        <button class="btn btn-primary" onclick="openUploadModal()" style="margin-top: 16px;">
                            + Tambah Video Pertama
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    
    <div class="modal" id="uploadModal">
        <div class="modal-dialog" style="max-width: 600px;">
            <form action="{{ route('mentor.material.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="modal-header">
                    <h3 class="h4">Tambah Video Baru</h3>
                    <button type="button" class="modal-close" onclick="closeUploadModal()">×</button>
                </div>
                
                <div class="modal-body">
                    
                    <div class="form-control">
                        <label>Pilih Kursus <span style="color: var(--danger);">*</span></label>
                        <select name="course_id" class="select" required>
                            <option value="">-- Pilih Kursus --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="form-control">
                        <label>Judul Video <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="title" placeholder="Contoh: JavaScript Basics - Variables and Data Types" required>
                    </div>

                    
                    <div class="form-control">
                        <label>Upload Video (MP4 Only) <span style="color: var(--danger);">*</span></label>
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">📹</div>
                            <h4 class="h4">Drag & Drop video di sini</h4>
                            <p class="text-muted">atau</p>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('videoInput').click()">
                                Pilih File dari Komputer
                            </button>
                            <p class="text-muted" style="font-size: 12px; margin-top: 12px;">
                                Format: MP4 | Max: 100MB
                            </p>
                        </div>
                        <input type="file" id="videoInput" name="video" accept="video/mp4" style="display: none;" required>
                        <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">

                            <div style="display: flex; gap: 8px;">
                                <button type="button" class="btn btn-ghost" onclick="closeUploadModal()">Batal</button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    Upload Video
                                </button>
                            </div>
                        </div>

                        
                        <div id="filePreview" style="display: none; margin-top: 12px; padding: 12px; background: #F0F4F8; border-radius: 8px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="font-size: 24px;">🎬</span>
                                <div style="flex: 1;">
                                    <strong id="fileName"></strong>
                                    <p class="text-muted" style="font-size: 12px; margin: 4px 0 0;" id="fileSize"></p>
                                </div>
                                <button type="button" class="icon-btn delete" onclick="removeFile()">×</button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-control">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_published" value="1" style="width: 18px; height: 18px;">
                            <span>Publikasikan langsung</span>
                        </label>
                    </div>
                </div>
                
                <div class="modal-footer" style="display: flex; gap: 8px; justify-content: flex-end; border-top: 1px solid #E5E7EB;">
                    <button type="button" class="btn btn-ghost" onclick="closeUploadModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        Upload Video
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="h4">Konfirmasi Hapus</h3>
                <button class="modal-close" onclick="closeDeleteModal()">×</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus video <strong id="deleteVideoName"></strong>?</p>
                <p class="text-muted" style="font-size: 13px;">Video yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer" style="display: flex; gap: 8px; justify-content: flex-end; border-top: 1px solid #E5E7EB;">
                <button class="btn btn-ghost" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: var(--danger); color: var(--white); border: none;">
                        Hapus Video
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="toast" id="toast">
        <span>✓</span>
        <span id="toastMessage">Aksi berhasil!</span>
    </div>

    <script>        function openUploadModal() {
            document.getElementById('uploadModal').classList.add('open');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.remove('open');
            document.getElementById('uploadForm').reset();
            document.getElementById('filePreview').style.display = 'none';
        }        const uploadArea = document.getElementById('uploadArea');
        const videoInput = document.getElementById('videoInput');

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('drag-over');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type === 'video/mp4') {
                    videoInput.files = files;
                    showFilePreview(file);
                } else {
                    showToast('❌ Hanya file MP4 yang diperbolehkan!');
                }
            }
        });        videoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                if (file.type === 'video/mp4') {
                    showFilePreview(file);
                } else {
                    showToast('❌ Hanya file MP4 yang diperbolehkan!');
                    videoInput.value = '';
                }
            }
        });        function showFilePreview(file) {
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            filePreview.style.display = 'block';
        }        function removeFile() {
            videoInput.value = '';
            document.getElementById('filePreview').style.display = 'none';
        }        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }        function confirmDelete(id, name) {
            const modal = document.getElementById('deleteModal');
            const videoName = document.getElementById('deleteVideoName');
            const deleteForm = document.getElementById('deleteForm');
            
            videoName.textContent = name;
            deleteForm.action = `/mentor/material/${id}`;
            
            modal.classList.add('open');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('open');
        }        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }        const successMsg = @json(session('success'));
        const errorMsg = @json(session('error'));
        
        if (successMsg) {
            showToast('✓ ' + successMsg);
        }
        
        if (errorMsg) {
            showToast('❌ ' + errorMsg);
        }        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('videoInput');
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                showToast('❌ Silakan pilih file video terlebih dahulu!');
                return false;
            }
            
            const file = fileInput.files[0];
            if (file.size > 100 * 1024 * 1024) {                e.preventDefault();
                showToast('❌ Ukuran file maksimal 100MB!');
                return false;
            }            const submitBtn = document.getElementById('submitBtn');
            submitBtn.textContent = 'Uploading...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>