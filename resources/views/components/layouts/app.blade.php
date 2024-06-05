<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'OnlyMaiNails' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script>document.documentElement.classList.add('js')</script>

</head>

<body class="h-full bg-white">
    <div class="flex flex-col min-h-screen pb-32 lg:pb-0">
        <div class="">
            @livewire('component.header')
        </div>
        <div class="flex-auto px-5 py-10">
            {{ $slot }}
        </div>
        <div class="bg-[#fadde1]">
            @livewire('component.footer')
        </div>
    </div>


    @vite('resources/js/datepicker.js')
    <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>

</body>



</html>
