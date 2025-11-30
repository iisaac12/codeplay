<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'question_options';
    protected $primaryKey = 'option_id';
    
    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'order_index'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];


    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}