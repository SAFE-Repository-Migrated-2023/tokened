<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.partials.head')
    
    <body class="antialiased">
        <div id="app">
            <x-navbar />
            <div class="relative max-w-6xl mx-auto px-2 sm:px-6 lg:px-8 py-10">
                @include('layouts.partials.alerts')
                @yield('main-content')
            </div>
        </div>

        @stack('bottom-scripts')
    </body>
</html>