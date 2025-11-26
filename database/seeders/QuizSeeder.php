<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\CodingTest;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Quiz untuk Laravel (course_id = 1)
        $quiz1 = Quiz::create([
            'course_id' => 1,
            'title' => 'Quiz Laravel Basics',
            'description' => 'Test pemahaman dasar Laravel',
            'time_limit' => 30, // 30 menit
            'passing_score' => 70,
            'order_index' => 1,
        ]);

        // Question 1 - Multiple Choice
        $q1 = Question::create([
            'quiz_id' => $quiz1->quiz_id,
            'question_text' => 'Apa kepanjangan dari MVC?',
            'question_type' => 'multiple_choice',
            'points' => 10,
            'order_index' => 1,
        ]);

        QuestionOption::create([
            'question_id' => $q1->question_id,
            'option_text' => 'Model View Controller',
            'is_correct' => true,
            'order_index' => 1,
        ]);

        QuestionOption::create([
            'question_id' => $q1->question_id,
            'option_text' => 'Model Visual Controller',
            'is_correct' => false,
            'order_index' => 2,
        ]);

        QuestionOption::create([
            'question_id' => $q1->question_id,
            'option_text' => 'Main View Code',
            'is_correct' => false,
            'order_index' => 3,
        ]);

        // Question 2 - Multiple Choice
        $q2 = Question::create([
            'quiz_id' => $quiz1->quiz_id,
            'question_text' => 'Command untuk membuat controller baru di Laravel?',
            'question_type' => 'multiple_choice',
            'points' => 10,
            'order_index' => 2,
        ]);

        QuestionOption::create([
            'question_id' => $q2->question_id,
            'option_text' => 'php artisan make:controller',
            'is_correct' => true,
            'order_index' => 1,
        ]);

        QuestionOption::create([
            'question_id' => $q2->question_id,
            'option_text' => 'php artisan create:controller',
            'is_correct' => false,
            'order_index' => 2,
        ]);

        QuestionOption::create([
            'question_id' => $q2->question_id,
            'option_text' => 'php artisan new:controller',
            'is_correct' => false,
            'order_index' => 3,
        ]);

        // Question 3 - Coding
        $q3 = Question::create([
            'quiz_id' => $quiz1->quiz_id,
            'question_text' => 'Tulis function PHP yang return "Hello Laravel"',
            'question_type' => 'coding',
            'points' => 20,
            'order_index' => 3,
        ]);

        CodingTest::create([
            'question_id' => $q3->question_id,
            'input_data' => '',
            'expected_output' => 'Hello Laravel',
            'is_hidden' => false,
        ]);
    }
}

