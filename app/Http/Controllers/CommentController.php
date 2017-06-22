<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
	
	public function store(Request $request)
	{

		/*
			Status
				1 = from your friend to you
				2 = from your friends to you
				3 = from you to your friend
		*/

		$comment = Comment::create([
			'post_id' => $request->post_id,
			'content' => $request->content,
			'user_id' => Auth::id()
		]);

		$new_comment = Comment::find($comment->id);
		$post = Post::find($comment->post_id);

		if ( $comment->user_id != $post->user_id ) {
		
			User::find($post->user_id)
				->notify(new \App\Notifications\CommentNotification($new_comment, '1'));

		} else {
			$init_user_ids = [];

			$get_comment_user_ids = Comment::where('post_id', $comment->post_id)->get();

			foreach($get_comment_user_ids as $value){
				array_push($init_user_ids, $value->user_id);
			}

			$user_ids = array_diff(array_unique($init_user_ids), [$post->user_id]);

			foreach($user_ids as $id){
				User::find($id)
					->notify(new \App\Notifications\CommentNotification($new_comment, '3'));
			}

		}

		broadcast(new \App\Events\NewComment($new_comment))->toOthers();

		return $new_comment;
	}

}
