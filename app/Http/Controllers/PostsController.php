<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;

class PostsController extends Controller
{
    
	public function store(Request $request)
	{
		$post = Post::create([
			'user_id' => Auth::id(),
			'content' => $request->content
		]);

		$new_post = Post::find($post->id);
	
		broadcast(new \App\Events\NewPost($new_post))->toOthers();

		return $new_post;
	}

}
