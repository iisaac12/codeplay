<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumThread;
use App\Models\ForumReply;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        // Thread 1
        $thread1 = ForumThread::create([
            'course_id' => 1,
            'user_id' => 5, // Andi (pelajar)
            'title' => 'Cara install Laravel di Windows?',
            'content' => 'Halo, saya pemula. Bagaimana cara install Laravel di Windows? Mohon bantuannya.',
            'is_pinned' => false,
            'is_locked' => false,
        ]);

        ForumReply::create([
            'thread_id' => $thread1->thread_id,
            'user_id' => 2, // Budi (mentor)
            'content' => 'Halo! Pertama install Composer dulu, lalu jalankan: composer create-project laravel/laravel nama-project',
            'is_solution' => true,
        ]);

        ForumReply::create([
            'thread_id' => $thread1->thread_id,
            'user_id' => 5, // Andi
            'content' => 'Terima kasih! Berhasil!',
            'is_solution' => false,
        ]);

        // Thread 2
        $thread2 = ForumThread::create([
            'course_id' => 1,
            'user_id' => 6, // Dewi (pelajar)
            'title' => 'Error SQLSTATE[HY000] [2002]',
            'content' => 'Saya dapat error ini saat migrate. Kenapa ya?',
            'is_pinned' => false,
            'is_locked' => false,
        ]);

        ForumReply::create([
            'thread_id' => $thread2->thread_id,
            'user_id' => 3, // Siti (mentor)
            'content' => 'Coba cek XAMPP/MAMP nya sudah jalan belum? Dan pastikan DB_HOST di .env sudah benar.',
            'is_solution' => true,
        ]);

        // Thread 3 - Pinned
        ForumThread::create([
            'course_id' => 1,
            'user_id' => 2, // Budi (mentor)
            'title' => '[PENTING] Resource Belajar Laravel',
            'content' => 'Berikut adalah link-link penting untuk belajar Laravel lebih lanjut...',
            'is_pinned' => true,
            'is_locked' => false,
        ]);
    }
}
