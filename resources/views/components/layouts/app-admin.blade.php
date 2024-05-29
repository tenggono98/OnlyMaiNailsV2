<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app-admin.css')
        @vite('resources/js/app.js')
        <title>{{ $title ?? 'Admin | Only Mai Nails' }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jacquard+12&display=swap" rel="stylesheet">
    </head>
    <body class="bg-gray-100 ">

        @livewire('component.admin.header')

        <div class="p-4 sm:ml-64">
            {{ $slot }}
        </div>

        <div class="relative bottom-0">
            @livewire('component.admin.footer')
        </div>

    </body>

</html>
