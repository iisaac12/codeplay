<?php

// ============================================
// database/seeders/DatabaseSeeder.php
// ============================================

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            CourseSeeder::class,
            CourseMaterialSeeder::class,
            TutorialSeeder::class,
            QuizSeeder::class,
            ForumSeeder::class,
            MentorForumSeeder::class,
            EnrollmentSeeder::class,
        ]);
    }
}
