<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorialStep extends Model
{
    protected $table = 'tutorial_steps';
    protected $primaryKey = 'step_id';
    
    public $timestamps = false;

    protected $fillable = [
        'tutorial_id',
        'step_number',
        'title',
        'instruction',
        'code_template',
        'solution_code',
        'hint'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class, 'tutorial_id', 'tutorial_id');
    }

    public function progress()
    {
        return $this->hasMany(TutorialProgress::class, 'step_id', 'step_id');
    }
}

