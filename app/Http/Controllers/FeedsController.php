<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;

class FeedsController extends Controller
{
    
	public function feed($id=null)
	{
		$user_logged_in_id = collect(Auth::id())->toArray();
		
		if ($id == null) {
			$friends_ids = Auth::user()->friends_ids();
			$where = array_merge($user_logged_in_id, $friends_ids);

			$feed = Post::whereIn('user_id', $where)
						->orderBy('id', 'DESC')
						->paginate(3);
		} else {
			$feed = Post::where('user_id', $id)
						->orderBy('id', 'DESC')
						->paginate(3);
		}

		return $feed;
	}

}
