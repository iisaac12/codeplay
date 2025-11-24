<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorForum extends Model
{
    protected $table = 'mentor_forums';
    protected $primaryKey = 'forum_id';

    protected $fillable = [
        'mentor_id',
        'title',
        'content',
        'category',
        'is_pinned',
        'view_count'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id', 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(MentorForumReply::class, 'forum_id', 'forum_id')
                    ->orderBy('created_at');
    }
}