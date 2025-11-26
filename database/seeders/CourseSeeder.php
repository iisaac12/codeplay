<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            // Web Development
            [
                'title' => 'Laravel untuk Pemula',
                'slug' => 'laravel-untuk-pemula',
                'description' => 'Belajar framework Laravel dari nol hingga mahir membuat aplikasi web.',
                'category_id' => 1,
                'mentor_id' => 2, // Budi
                'level' => 'beginner',
                'is_published' => true,
                'is_verified' => true,
            ],
            [
                'title' => 'React JS Fundamentals',
                'slug' => 'react-js-fundamentals',
                'description' => 'Pelajari React JS untuk membuat user interface yang interaktif.',
                'category_id' => 1,
                'mentor_id' => 2, // Budi
                'level' => 'intermediate',
                'is_published' => true,
                'is_verified' => true,
            ],
            [
                'title' => 'REST API dengan Node.js',
                'slug' => 'rest-api-nodejs',
                'description' => 'Membuat REST API profesional menggunakan Node.js dan Express.',
                'category_id' => 1,
                'mentor_id' => 3, // Siti
                'level' => 'intermediate',
                'is_published' => true,
                'is_verified' => true,
            ],

            // Mobile Development
            [
                'title' => 'Flutter untuk Pemula',
                'slug' => 'flutter-untuk-pemula',
                'description' => 'Belajar Flutter untuk membuat aplikasi mobile Android dan iOS.',
                'category_id' => 2,
                'mentor_id' => 3, // Siti
                'level' => 'beginner',
                'is_published' => true,
                'is_verified' => true,
            ],
            [
                'title' => 'React Native Mastery',
                'slug' => 'react-native-mastery',
                'description' => 'Kuasai React Native untuk membuat aplikasi mobile cross-platform.',
                'category_id' => 2,
                'mentor_id' => 4, // Agus
                'level' => 'advanced',
                'is_published' => true,
                'is_verified' => true,
            ],

            // Data Science
            [
                'title' => 'Python untuk Data Science',
                'slug' => 'python-data-science',
                'description' => 'Belajar Python untuk analisis data dan visualisasi.',
                'category_id' => 3,
                'mentor_id' => 4, // Agus
                'level' => 'beginner',
                'is_published' => true,
                'is_verified' => true,
            ],
            [
                'title' => 'Machine Learning Praktis',
                'slug' => 'machine-learning-praktis',
                'description' => 'Implementasi machine learning dengan Python dan scikit-learn.',
                'category_id' => 3,
                'mentor_id' => 2, // Budi
                'level' => 'advanced',
                'is_published' => true,
                'is_verified' => true,
            ],

            // Programming Basics
            [
                'title' => 'Pemrograman Python Dasar',
                'slug' => 'python-dasar',
                'description' => 'Belajar Python dari nol untuk pemula yang belum pernah coding.',
                'category_id' => 4,
                'mentor_id' => 3, // Siti
                'level' => 'beginner',
                'is_published' => true,
                'is_verified' => true,
            ],
            [
                'title' => 'JavaScript Fundamentals',
                'slug' => 'javascript-fundamentals',
                'description' => 'Dasar-dasar JavaScript untuk pemrograman web.',
                'category_id' => 4,
                'mentor_id' => 2, // Budi
                'level' => 'beginner',
                'is_published' => true,
                'is_verified' => true,
            ],

            // Database
            [
                'title' => 'MySQL untuk Pemula',
                'slug' => 'mysql-pemula',
                'description' => 'Belajar database MySQL dari dasar hingga query kompleks.',
                'category_id' => 5,
                'mentor_id' => 4, // Agus
                'level' => 'beginner',
                'is_published' => true,
                'is_verified' => true,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}