@extends('layouts.app')

@section('content')
	
<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					{{ $user->name }}'s profile
					
				</div>
				<div class="panel-body">
				
					<center>
						<img src="{{ $user->avatar }}" width="140px" height="140px" style="border-radius: 50%">
					</center>

					<br>
					<p class="text-center">
						{{ $user->profile->location }}
					</p>
					<br>

					<p class="text-center">
						
						@if(Auth::id() == $user->id)

							<a href="{{ route('profile.edit') }}" class="btn btn-sm btn-info">Edit your profile</a>

						@endif

					</p>
				</div>
			</div>
			@if (Auth::id() != $user->id)
				<div class="panel panel-primary">
					<div class="panel-body">
						<friend :profile_user_id="{{ $user->id }}"></friend>
					</div>
				</div>
			@endif

			<div class="panel panel-primary">
				<div class="panel-heading">
					About me
				</div>
				<div class="panel-body">
						
					{{ $user->profile->about }}

				</div>
			</div>

			<friendlist :id="{{ $user->id }}"></friendlist>

		</div>

		<div class="col-lg-8">
			@if(Auth::id() == $user->id)
				<post></post>
			@endif
	    	<feed :id="{{ $user->id }}"></feed>
		</div>
	</div>
</div>

@endsection