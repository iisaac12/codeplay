<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorForumReply extends Model
{
    protected $table = 'mentor_forum_replies';
    protected $primaryKey = 'reply_id';

    protected $fillable = [
        'forum_id',
        'mentor_id',
        'content'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function forum()
    {
        return $this->belongsTo(MentorForum::class, 'forum_id', 'forum_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id', 'user_id');
    }
}
