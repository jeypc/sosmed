<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class SearchController extends Controller
{
    
	public function search(Request $request)
	{
		if(!empty($request['query']))

			$users = User::where('name', 'like', '%' . $request['query'] . '%')->get();
		else

			$users = [];
		
		return view('search')->with('users', $users);
	}

}
