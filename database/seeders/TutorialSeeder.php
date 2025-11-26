<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tutorial;
use App\Models\TutorialStep;

class TutorialSeeder extends Seeder
{
    public function run(): void
    {
        // Tutorial untuk Laravel (course_id = 1)
        $tutorial1 = Tutorial::create([
            'course_id' => 1,
            'title' => 'Membuat Route Pertama',
            'description' => 'Tutorial interaktif untuk membuat routing di Laravel',
            'order_index' => 1,
        ]);

        // Steps untuk tutorial Laravel
        TutorialStep::create([
            'tutorial_id' => $tutorial1->tutorial_id,
            'step_number' => 1,
            'title' => 'Buat Route GET',
            'instruction' => 'Buatlah sebuah route GET dengan path /hello yang mengembalikan string "Hello World"',
            'code_template' => "Route::get('/', function() {\n    // Tulis kode di sini\n});",
            'solution_code' => "Route::get('/hello', function() {\n    return 'Hello World';\n});",
            'hint' => 'Gunakan Route::get() dengan path /hello',
        ]);

        TutorialStep::create([
            'tutorial_id' => $tutorial1->tutorial_id,
            'step_number' => 2,
            'title' => 'Route dengan Parameter',
            'instruction' => 'Buat route dengan parameter {name} yang mengembalikan "Hello {name}"',
            'code_template' => "Route::get('/hello/{name}', function() {\n    // Tulis kode di sini\n});",
            'solution_code' => "Route::get('/hello/{name}', function(\$name) {\n    return 'Hello ' . \$name;\n});",
            'hint' => 'Parameter route dapat diakses sebagai function parameter',
        ]);

        // Tutorial untuk React (course_id = 2)
        $tutorial2 = Tutorial::create([
            'course_id' => 2,
            'title' => 'Membuat Component Pertama',
            'description' => 'Belajar membuat functional component di React',
            'order_index' => 1,
        ]);

        TutorialStep::create([
            'tutorial_id' => $tutorial2->tutorial_id,
            'step_number' => 1,
            'title' => 'Simple Component',
            'instruction' => 'Buat functional component bernama Greeting yang return <h1>Hello React</h1>',
            'code_template' => "function Greeting() {\n    // Tulis kode di sini\n}",
            'solution_code' => "function Greeting() {\n    return <h1>Hello React</h1>;\n}",
            'hint' => 'Component harus return JSX element',
        ]);
    }
}
