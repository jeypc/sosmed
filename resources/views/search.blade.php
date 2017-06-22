@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Search result</div>

                <div class="panel-body">
                    <ul class="list-group">

                        @forelse($users as $user)

                            <li class="list-group-item">
                                <img src="{{ $user->avatar }}" width="40px" height="40px">

                                <a href="{{ route('profile', ['slug' => $user->slug]) }}">{{ $user->name }}</a>
                            </li>

                        @empty

                            Result not found

                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
