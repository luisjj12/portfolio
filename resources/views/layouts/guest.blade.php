<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { color-scheme: light only; }
        * { box-sizing: border-box; }
        label { color: #374151 !important; background: transparent !important; }
        input  { color: #1F2A44 !important; background: #F9FAFB !important; }
        input:focus { background: #ffffff !important; }
    </style>
</head>

<body class="font-sans antialiased bg-[#F0F2F5] text-[#111827]">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        {{ $slot }}
    </div>

    <script>
        // En móvil, el teclado virtual puede tapar el campo que se está rellenando.
        // Al enfocar un campo, lo desplazamos al centro de la pantalla visible.
        document.addEventListener('focusin', function (e) {
            if (e.target.matches('input, textarea, select')) {
                setTimeout(function () {
                    e.target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
            }
        });
    </script>
</body>

</html>
