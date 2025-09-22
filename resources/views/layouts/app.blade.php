<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'BIA Dental Center')</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="app-content">
        @include('components.header')


        <!-- Main Content Section -->
        <div class="mx-auto">
            @yield('content')
        </div>

        <!-- Footer Section -->
        @if (!isset($hideFooter) || !$hideFooter)
            @include('components.footer')
        @endif
    </div>
</body>

</html>
