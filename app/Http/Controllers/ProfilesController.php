<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;

class ProfilesController extends Controller
{
    
	public function index($slug)
	{
		$user = User::where('slug', $slug)->first();

		return view('profiles.profile')
			   ->with('user', $user);
	}

	public function edit()
	{
		return view('profiles.edit')->with('info', Auth::user()->profile);
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'location' => 'required',
			'about'	   => 'required|max:255'
		]);

		Auth::user()->profile()->update([
			'location' => $request->location,
			'about'	   => $request->about
		]);

		if ( $request->hasFile('avatar') ) {
			Auth::user()->update([
				'avatar' => $request->avatar->store('public/avatars')
			]);
		}

		Session::flash('success', 'Profile updated.');
		return redirect()->back();
	}

	public function friend($id)
	{
		if ($id == Auth::id() ) {
			$friends = Auth::user()->friends();
		} else {
			$friends = Auth::user()->friends($id);
		}

		return $friends;
	}

}
