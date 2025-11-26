<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseMaterial;

class CourseMaterialSeeder extends Seeder
{
    public function run(): void
    {
        // Materials untuk course "Laravel untuk Pemula" (course_id = 1)
        $laravelMaterials = [
            [
                'course_id' => 1,
                'title' => 'Pengenalan Laravel',
                'type' => 'video',
                'content' => null,
                'file_url' => 'materials/laravel-intro.mp4',
                'order_index' => 1,
                'duration' => 900, // 15 menit
            ],
            [
                'course_id' => 1,
                'title' => 'Instalasi Laravel',
                'type' => 'video',
                'content' => null,
                'file_url' => 'materials/laravel-install.mp4',
                'order_index' => 2,
                'duration' => 1200, // 20 menit
            ],
            [
                'course_id' => 1,
                'title' => 'Routing Dasar',
                'type' => 'text',
                'content' => 'Routing adalah proses menentukan bagaimana aplikasi merespons request dari client...',
                'file_url' => null,
                'order_index' => 3,
                'duration' => null,
            ],
            [
                'course_id' => 1,
                'title' => 'Contoh Routing',
                'type' => 'code',
                'content' => "Route::get('/home', function() {\n    return view('home');\n});",
                'file_url' => null,
                'order_index' => 4,
                'duration' => null,
            ],
            [
                'course_id' => 1,
                'title' => 'Cheatsheet Laravel',
                'type' => 'pdf',
                'content' => null,
                'file_url' => 'materials/laravel-cheatsheet.pdf',
                'order_index' => 5,
                'duration' => null,
            ],
        ];

        // Materials untuk "React JS Fundamentals" (course_id = 2)
        $reactMaterials = [
            [
                'course_id' => 2,
                'title' => 'Intro to React',
                'type' => 'video',
                'content' => null,
                'file_url' => 'materials/react-intro.mp4',
                'order_index' => 1,
                'duration' => 800,
            ],
            [
                'course_id' => 2,
                'title' => 'JSX Basics',
                'type' => 'text',
                'content' => 'JSX adalah syntax extension untuk JavaScript...',
                'file_url' => null,
                'order_index' => 2,
                'duration' => null,
            ],
            [
                'course_id' => 2,
                'title' => 'Components Example',
                'type' => 'code',
                'content' => "function Welcome(props) {\n  return <h1>Hello, {props.name}</h1>;\n}",
                'file_url' => null,
                'order_index' => 3,
                'duration' => null,
            ],
        ];

        // Materials untuk "Python Data Science" (course_id = 6)
        $pythonMaterials = [
            [
                'course_id' => 6,
                'title' => 'Python Basics',
                'type' => 'video',
                'content' => null,
                'file_url' => 'materials/python-basics.mp4',
                'order_index' => 1,
                'duration' => 1500,
            ],
            [
                'course_id' => 6,
                'title' => 'NumPy Introduction',
                'type' => 'text',
                'content' => 'NumPy adalah library fundamental untuk scientific computing...',
                'file_url' => null,
                'order_index' => 2,
                'duration' => null,
            ],
        ];

        foreach (array_merge($laravelMaterials, $reactMaterials, $pythonMaterials) as $material) {
            CourseMaterial::create($material);
        }
    }
}