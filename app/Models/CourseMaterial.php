<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    protected $table = 'course_materials';
    protected $primaryKey = 'material_id';
    
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'title',
        'type',
        'content',
        'file_url',
        'order_index',
        'duration'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function progress()
    {
        return $this->hasMany(MaterialProgress::class, 'material_id', 'material_id');
    }

    public function downloads()
    {
        return $this->hasMany(Download::class, 'material_id', 'material_id');
    }
}