<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    protected $table = 'forum_replies';
    protected $primaryKey = 'reply_id';

    protected $fillable = [
        'thread_id',
        'user_id',
        'content',
        'is_solution'
    ];

    protected $casts = [
        'is_solution' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'thread_id', 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
