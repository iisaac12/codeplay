<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'question_options';
    protected $primaryKey = 'option_id'; // Kunci utama custom sesuai DB
    
    public $timestamps = false; // Tabel ini tidak punya created_at/updated_at

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'order_index'
    ];

    protected $casts = [
        'is_correct' => 'boolean', // Ubah 1/0 jadi true/false otomatis
    ];

    // Relationships
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}