@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Notifications</div>

                <div class="panel-body">
                    <ul class="list-group">

                        @forelse($notifications as $notification)

                            <li class="list-group-item">
                                <a href="{{ route('profile', ['slug' => str_slug($notification->data['name'])] ) }}">
                                    <b>{{ $notification->data['name'] }}</b>
                                </a>
                                {{ $notification->data['message'] }}
                                <span class="pull-right">{{ $notification->created_at->diffForHumans() }}</span>
                            </li>

                        @empty
                            Notification is empty

                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
