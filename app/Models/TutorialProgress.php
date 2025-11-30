<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorialProgress extends Model
{
    protected $table = 'tutorial_progress';
    protected $primaryKey = 'progress_id';
    
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'step_id',
        'is_completed',
        'user_code',
        'completed_at'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function step()
    {
        return $this->belongsTo(TutorialStep::class, 'step_id', 'step_id');
    }
}
