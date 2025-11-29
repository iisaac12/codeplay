<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table = 'user_answers';
    protected $primaryKey = 'answer_id';
    public $timestamps = false; // Karena di DB cuma ada answered_at

    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_id',
        'answer_text',
        'is_correct',
        'points_earned',
        'answered_at'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'answered_at' => 'datetime'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }

    public function selectedOption()
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id', 'option_id');
    }
}