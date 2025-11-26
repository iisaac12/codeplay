<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Belajar membuat website dan aplikasi web',
                'icon_url' => '🌐'
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Belajar membuat aplikasi mobile Android & iOS',
                'icon_url' => '📱'
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Belajar analisis data dan machine learning',
                'icon_url' => '📊'
            ],
            [
                'name' => 'Programming Basics',
                'slug' => 'programming-basics',
                'description' => 'Dasar-dasar pemrograman untuk pemula',
                'icon_url' => '💻'
            ],
            [
                'name' => 'Database',
                'slug' => 'database',
                'description' => 'Belajar database dan manajemen data',
                'icon_url' => '🗄️'
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'Belajar deployment dan CI/CD',
                'icon_url' => '🚀'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
