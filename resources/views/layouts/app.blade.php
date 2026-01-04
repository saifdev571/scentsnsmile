<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Scents N Smile')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @include('partials.styles')
    
    @stack('styles')
</head>
<body class="bg-transparent">
    @include('partials.header')
    
    @yield('content')
    
    @include('partials.footer')
    
    @include('partials.scripts')
    
    @stack('scripts')
</body>
</html>
