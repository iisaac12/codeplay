<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserEnrollment;
use App\Models\MaterialProgress;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Andi enroll ke Laravel course
        $enrollment1 = UserEnrollment::create([
            'user_id' => 5, // Andi
            'course_id' => 1, // Laravel
            'progress_percentage' => 40.00,
        ]);

        // Progress materials
        MaterialProgress::create([
            'user_id' => 5,
            'material_id' => 1,
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        MaterialProgress::create([
            'user_id' => 5,
            'material_id' => 2,
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        // Dewi enroll ke React course
        UserEnrollment::create([
            'user_id' => 6, // Dewi
            'course_id' => 2, // React
            'progress_percentage' => 20.00,
        ]);

        // Rudi enroll ke Python course
        UserEnrollment::create([
            'user_id' => 7, // Rudi
            'course_id' => 6, // Python
            'progress_percentage' => 60.00,
        ]);

        // Maya enroll ke Flutter
        UserEnrollment::create([
            'user_id' => 8, // Maya
            'course_id' => 4, // Flutter
            'progress_percentage' => 10.00,
        ]);

        // Joko enroll ke JavaScript
        UserEnrollment::create([
            'user_id' => 9, // Joko
            'course_id' => 9, // JavaScript
            'progress_percentage' => 50.00,
        ]);
    }
}
