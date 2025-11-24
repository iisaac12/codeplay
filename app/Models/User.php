<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'full_name',
        'role',
        'avatar_url',
        'is_verified',
        'is_active'
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function enrollments()
    {
        return $this->hasMany(UserEnrollment::class, 'user_id', 'user_id');
    }

    public function coursesAsMentor()
    {
        return $this->hasMany(Course::class, 'mentor_id', 'user_id');
    }

    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class, 'user_id', 'user_id');
    }

    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class, 'user_id', 'user_id');
    }

    public function mentorForums()
    {
        return $this->hasMany(MentorForum::class, 'mentor_id', 'user_id');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'user_id', 'user_id');
    }

    public function downloads()
    {
        return $this->hasMany(Download::class, 'user_id', 'user_id');
    }

    // Helper method untuk cek role
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPelajar()
    {
        return $this->role === 'pelajar';
    }
}