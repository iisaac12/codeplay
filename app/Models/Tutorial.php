<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $table = 'tutorials';
    protected $primaryKey = 'tutorial_id';
    
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order_index'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function steps()
    {
        return $this->hasMany(TutorialStep::class, 'tutorial_id', 'tutorial_id')
                    ->orderBy('step_number');
    }
}