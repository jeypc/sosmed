<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    
	public $with = ['user'];

	protected $fillable = ['user_id', 'post_id'];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
