@extends('layouts.app')
@section('main-content')

<div class="m-auto w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">
    <h2 class="mb-6 font-extrabold text-gray-900">Safe Username: {{$safe_id}}</h2>
    <p>A notification has been sent to your mobile device for authentication.</p>
    <p class="mt-2 text-red-400">If you did not receive a notification, please check that notifications are turned ‘on’ for The SAFE Button app.</p>
</div>

<signin-safe aid="{{$anchor_id}}"></signin-safe>
@endsection