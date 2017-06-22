<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function(){

	Route::get('profile/{slug}', 'ProfilesController@index')->name('profile');
	Route::get('profile/friend/{slug}', 'ProfilesController@friend')->name('friendlist');
	Route::get('profile/edit/profile', 'ProfilesController@edit')->name('profile.edit');
	Route::post('profile/update/profile', 'ProfilesController@update')->name('profile.update');
	Route::get('check_realationship_status/{id}', 'FriendshipsController@check')->name('check');
	Route::get('add_friend/{id}', 'FriendshipsController@add_friend')->name('add_friend');
	Route::get('accept_friend/{id}', 'FriendshipsController@accept_friend')->name('accept_friend');

	Route::get('/get_unread', function(){
		return Auth::user()->unreadNotifications;
	});

	Route::get('notifications', 'HomeController@notifications')->name('notifications');
	Route::post('create/post', 'PostsController@store');
	Route::get('feed/{id?}', 'FeedsController@feed')->name('feed');

	Route::get('get_auth_user_data', function(){
		return Auth::user();
	});

	Route::get('like/{id}', 'LikesController@like');
	Route::get('unlike/{id}', 'LikesController@unlike');

	Route::post('comment', 'CommentController@store');

	Route::get('check_is_friends/{id}', function($id){
		return Auth::user()->is_friend_with($id);
	});

	Route::get('search', 'SearchController@search')->name('search');
});
