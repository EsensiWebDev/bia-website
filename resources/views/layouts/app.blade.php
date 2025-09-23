<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'BIA Dental Center')</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Signika:wght@400;700&display=swap"
        rel="stylesheet">

</head>

<body class="relative">
    <div id="app-content">
        @include('components.header')


        <!-- Main Content Section -->
        <main class="relative z-0">
            @yield('content')
        </main>

        <!-- Footer Section -->
        @if (!isset($hideFooter) || !$hideFooter)
            @include('components.footer')
        @endif
    </div>
</body>

</html>
