<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'question_id'; // Kunci utama agar relasi terbaca
    
    public $timestamps = false;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'points',
        'order_index'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'quiz_id');
    }

    public function options()
    {
        // Relasi ke opsi jawaban, diurutkan biar A, B, C, D rapi
        return $this->hasMany(QuestionOption::class, 'question_id', 'question_id')
                    ->orderBy('order_index');
    }

    public function codingTests()
    {
        return $this->hasMany(CodingTest::class, 'question_id', 'question_id');
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'question_id', 'question_id');
    }
}