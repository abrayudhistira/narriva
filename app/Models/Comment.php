<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id', 'user_id', 'comment', 'parent_comment_id'
    ];

    // Relasi dengan post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan komentar parent (untuk balasan)
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    // Relasi dengan balasan komentar (untuk balasan)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }
}