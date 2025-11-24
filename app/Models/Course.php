<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail_url',
        'category_id',
        'mentor_id',
        'level',
        'is_published',
        'is_verified'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_verified' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id', 'user_id');
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class, 'course_id', 'course_id')
                    ->orderBy('order_index');
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class, 'course_id', 'course_id')
                    ->orderBy('order_index');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id', 'course_id')
                    ->orderBy('order_index');
    }

    public function enrollments()
    {
        return $this->hasMany(UserEnrollment::class, 'course_id', 'course_id');
    }

    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class, 'course_id', 'course_id');
    }
}

