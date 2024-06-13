<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Nunito">
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="min-h-screen flex flex-col md:flex-row bg-gradient-to-r from-blue-600 to-cyan-500">
        <!-- Left side with the logo and title -->
        <div class="w-full md:w-1/3 flex flex-col items-center justify-center bg-blue-100 p-6 md:p-0 rounded-lg">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-6 text-center shadow-md p-4 rounded-md text-black">
                Archiving System
            </h1>

            <img src="{{ asset('images/cerebrologo.png') }}" alt="Cerebro Logo" class="h-32">
            
        </div>

        <!-- Right side with the form content -->
        <div class="w-full md:w-2/3 flex items-center justify-center p-6 md:p-0 min-h-screen">
            <div class="w-full max-w-md p-8 rounded-lg shadow-2xl bg-white">
                <h2 class="text-3xl font-bold text-center text-indigo-600 mb-6">SIGN IN</h2>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
