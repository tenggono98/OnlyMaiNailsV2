<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>{{ $title ?? 'OnlyMaiNails' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-v2.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Krub:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <script>document.documentElement.classList.add('js')</script>

</head>

<body class="h-full bg-white ">
    <div id="page-loading-overlay" class="fixed inset-0 bg-white/70 backdrop-blur-sm items-center justify-center z-[9999] hidden">
        <div class="flex flex-col items-center gap-4">
            <div class="h-12 w-12 border-4 border-gray-300 border-t-[#efcabe] rounded-full animate-spin"></div>
            <div class="text-gray-700">Loading...</div>
        </div>
    </div>
    <div class="hidden xl:block">
        <svg width="1040" height="986" viewBox="0 0 1040 986" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute right-0 top-28 -z-10 opacity-80 ">
            <path d="M1200.75 590.917C1195.61 588.579 1190.35 585.973 1184.24 582.698L1181.71 581.333L967.795 413.464L917.358 679.86L916.38 682.532C913.995 688.814 911.701 694.378 909.369 699.503C906.77 705.215 903.933 710.721 900.995 716.184C955.575 749.278 1024.17 758.067 1088.5 734.078C1152.83 710.092 1198.73 658.65 1218.05 598.034C1212.25 595.84 1206.46 593.515 1200.75 590.917Z" fill="#efcabe" fill-opacity="0.5"/>
            <path d="M303.113 181.775C296.608 179.31 291.229 177.074 286.09 174.735C280.34 172.119 274.776 169.304 269.319 166.351C236.309 220.735 227.682 289.142 251.86 353.398C276.053 417.663 327.726 463.599 388.533 483.007C390.743 477.213 393.033 471.457 395.632 465.745C397.936 460.681 400.524 455.458 403.809 449.33L405.151 446.799L572.878 233.77L305.783 182.778L303.113 181.775Z" fill="#efcabe" fill-opacity="0.5"/>
            <path d="M1344.24 111.103C1339.94 109.147 1335.6 107.406 1331.23 105.751L1056.94 53.3949L1229.15 -165.363C1231.37 -169.453 1233.46 -173.644 1235.4 -177.908C1284.56 -285.946 1236.53 -413.51 1128.18 -462.814C1019.8 -512.127 892.071 -464.531 842.914 -356.494C840.974 -352.231 839.228 -347.879 837.563 -343.538L785.767 -69.9923L566.136 -242.374C562.002 -244.586 557.855 -246.709 553.536 -248.675C445.156 -297.988 317.432 -250.392 268.284 -142.376C219.126 -34.3385 267.151 93.2251 375.531 142.539C379.808 144.485 384.175 146.236 388.567 147.881L662.81 200.238L490.604 418.996C488.426 423.106 486.3 427.26 484.351 431.541C435.203 539.558 483.226 667.12 591.608 716.435C699.967 765.739 827.69 718.145 876.839 610.126C878.788 605.845 880.562 601.528 882.188 597.17L933.984 323.624L1153.66 496.005C1157.75 498.218 1161.94 500.36 1166.24 502.316C1274.62 551.629 1402.32 504.026 1451.48 395.986C1500.63 287.971 1452.64 160.425 1344.24 111.103ZM809.744 236.969C748.695 209.191 721.648 137.35 749.333 76.5054C777.026 15.6428 848.96 -11.1615 910.006 16.6152C971.074 44.4013 998.119 116.245 970.428 177.105C942.743 237.95 870.811 264.755 809.744 236.969Z" fill="#efcabe" fill-opacity="0.5"/>
        </svg>
    </div>


    <div class="flex flex-col min-h-screen lg:pb-0">
        <div class="">
            @livewire('component.header')
        </div>


        <div class="flex-auto">
      

            <div class="  xl:px-32 px-10 w-full py-20  min-h-screen ">
                {{ $slot }}
            </div>

        </div>
        <div class="bg-primary  flex-shrink">
            @livewire('component.footer')
        </div>
    </div>


   


    @vite('resources/js/datepicker.js')
    <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>
    <script>
        // Apply lazy-loading and async decoding to images that don't explicitly opt out
        (function() {
            if (!('loading' in HTMLImageElement.prototype)) return; // native support guard
            var images = document.querySelectorAll('img:not([loading])');
            images.forEach(function(img){
                // Keep likely critical images eager if explicitly marked via data-eager
                if (!img.hasAttribute('data-eager')) {
                    img.setAttribute('loading', 'lazy');
                }
                if (!img.hasAttribute('decoding')) {
                    img.setAttribute('decoding', 'async');
                }
            });
            // Defer non-critical iframes by default when not specified
            var iframes = document.querySelectorAll('iframe:not([loading])');
            iframes.forEach(function(frame){
                frame.setAttribute('loading', 'lazy');
            });
        })();
    </script>
    <script>
        // Simple page transition loader for navigations
        (function() {
            var overlay = document.getElementById('page-loading-overlay');
            function showOverlay() { if (overlay) { overlay.classList.remove('hidden'); overlay.classList.add('flex'); } }
            function hideOverlay() { if (overlay) { overlay.classList.add('hidden'); overlay.classList.remove('flex'); } }

            // Initial hide after paint
            window.addEventListener('load', hideOverlay);
            // Show on navigation away
            window.addEventListener('beforeunload', function() { showOverlay(); });
            // Handle bfcache restore
            window.addEventListener('pageshow', function(e){ if (e.persisted) hideOverlay(); });

            // Intercept regular same-origin link clicks
            document.addEventListener('click', function(e){
                var link = e.target && e.target.closest ? e.target.closest('a') : null;
                if (!link) return;
                if (link.hasAttribute('download')) return;
                var target = link.getAttribute('target');
                if (target && target.toLowerCase() === '_blank') return;
                var href = link.getAttribute('href') || '';
                if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
                if (e.defaultPrevented) return;
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
                try {
                    var url = new URL(href, window.location.href);
                    if (url.origin !== window.location.origin) return;
                    // In-page hash on same path
                    if (url.pathname === window.location.pathname && url.hash) return;
                    showOverlay();
                } catch(err) { /* noop */ }
            }, true);
        })();
    </script>

</body>

<x-livewire-alert::scripts />



</html>
