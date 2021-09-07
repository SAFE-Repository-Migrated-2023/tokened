<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="shortcut icon" href="{{ asset('img/favicon.ico')}}"> --}}
    {{-- <link rel="apple-touch-icon-precomposed" href="{{ asset('img/touch_icon.png')}}"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">

    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;900&display=swap'" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css').'?_m='.filemtime(public_path() . '/css/app.css')}}" media="all">
    <script src="{{ asset('js/app.js').'?_m='.filemtime(public_path() . '/js/app.js')}}" defer></script>
    {{-- <script src="{{ mix('/js/app.js') }}" defer></script> --}}

    @stack('scripts')
</head>