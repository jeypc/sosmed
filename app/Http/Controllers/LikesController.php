<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Post;
use App\Like;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    
	public function like($id)
	{
		$post = Post::find($id);

		$like = Like::create([
			'user_id' => Auth::id(),
			'post_id' => $post->id
		]);

		$new_like = Like::find($like->id);
		$user = User::find($like->user_id);

		if($post->user->id != Auth::id()) {
			User::find($post->user->id)
				->notify(new \App\Notifications\LikesNotification($new_like, $user) );
		}

		return $new_like;
	}

	public function unlike($id)
	{
		$post = Post::find($id);

		$like = Like::where('user_id', Auth::id())
			->where('post_id', $post->id)
			->first();

		$like->delete();
		
		return $like->id;
	}

}
