@extends('layouts.app')
@section('main-content')
<x-auth-card>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <h2 class="mb-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
    <p class="mt-2 text-center text-sm text-gray-600">Continue with SAFE</p>
    <form method="POST" action="{{ route('login.safe') }}">
        @csrf
         <!-- SAFE ID -->
         <div>
            <x-label for="safe" :value="__('SAFE username')" />
            <x-input id="safe" class="block mt-1 w-full" type="text" name="safe_id" :value="old('safe_id')" required autofocus />
        </div>
        <button type="submit" class="btn btn-primary mt-4 w-full">{{ __('Log in') }}</button>
    </form>

    {{-- <p class="my-12 text-center text-sm text-gray-600">Or with email/password</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-label for="password" :value="__('Password')" />
            <x-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="my-4 flex items-center justify-between">
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="text-sm">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4 w-full">{{ __('Log in') }}</button>
    </form> --}}
</x-auth-card>
@endsection
