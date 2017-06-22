<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	public $with = ['user', 'likes', 'comments'];

    protected $fillable = ['user_id', 'content'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function likes()
    {
    	return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
