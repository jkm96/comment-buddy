<?php

namespace CommentBuddy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Comment extends Model
{
    protected $fillable = ['body', 'post_id', 'user_id', 'parent_id'];

    public function user() {
        return $this->belongsTo(Config::get('auth.providers.users.model'));
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('children');
    }
}
