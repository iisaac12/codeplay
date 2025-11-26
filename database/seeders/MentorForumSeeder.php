<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MentorForum;
use App\Models\MentorForumReply;

class MentorForumSeeder extends Seeder
{
    public function run(): void
    {
        // Forum 1
        $forum1 = MentorForum::create([
            'mentor_id' => 2, // Budi
            'title' => 'Tips Membuat Video Tutorial yang Menarik',
            'content' => 'Share tips kalian untuk membuat video tutorial yang engage dan mudah dipahami!',
            'category' => 'tips',
            'is_pinned' => true,
        ]);

        MentorForumReply::create([
            'forum_id' => $forum1->forum_id,
            'mentor_id' => 3, // Siti
            'content' => 'Saya selalu pakai storytelling di awal untuk hook viewers!',
        ]);

        MentorForumReply::create([
            'forum_id' => $forum1->forum_id,
            'mentor_id' => 4, // Agus
            'content' => 'Audio quality penting banget! Invest di mic yang bagus.',
        ]);

        // Forum 2
        MentorForum::create([
            'mentor_id' => 3, // Siti
            'title' => 'Bagaimana cara handle student yang stuck?',
            'content' => 'Ada saran untuk membantu student yang kesulitan tanpa langsung kasih jawaban?',
            'category' => 'question',
            'is_pinned' => false,
        ]);
    }
}