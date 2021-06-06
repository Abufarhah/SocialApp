<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'content','comment_id','parent_comment_id'
    ];

    /**
     * Get the comment that owns the comment.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Get the replies for the reply.
     */
    public function replies()
    {
        return $this->hasMany(Reply::class,'parent_comment_id');
    }

    /**
     * Get the recursively nested replies for the reply.
     */
    public function allReplies()
    {
        return $this->replies()->with('allReplies');
    }
}
