<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Teamable')</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
    @yield('style')
</head>

<body class="font-sans antialiased text-gray-800 bg-surface">
    @yield('content')
</body>
</html>
