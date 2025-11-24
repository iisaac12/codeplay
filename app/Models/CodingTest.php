<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodingTest extends Model
{
    protected $table = 'coding_tests';
    protected $primaryKey = 'test_id';
    
    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'input_data',
        'expected_output',
        'is_hidden'
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    // Relationships
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'question_id');
    }
}

