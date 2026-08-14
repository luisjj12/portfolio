<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'MiTienda — Todo lo que buscas, a un clic de distancia')</title>
        <meta name="description" content="@yield('description', 'Encuentra los productos mejor valorados, las últimas novedades y las mejores ofertas en MiTienda.')">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


        <script src="https://cdn.tailwindcss.com"></script>
        <style>[x-cloak] { display: none !important; }</style>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 ">
            @include('layouts.navigation')

            @if (session('aviso'))
                <div class="bg-amber-50 border-b border-amber-200 text-amber-800 text-sm font-semibold text-center py-3 px-4">
                    {{ session('aviso') }}
                </div>
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Swiper JS -->
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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

    <footer class="bg-gray-900 text-white mt-16">
    <div class="max-w-7xl mx-auto py-12 px-6 md:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- Marca o logo -->
        <div>
            <h2 class="text-2xl font-bold mb-4">MiTienda</h2>
            <p class="text-gray-400">Ofrecemos productos de calidad al mejor precio. Gracias por confiar en nosotros.</p>
        </div>

        <!-- Enlaces útiles -->
        <div>
            <h3 class="text-lg font-semibold mb-4">Enlaces</h3>
            <ul class="space-y-2 text-gray-400">
                <li><a href="/" class="hover:text-white transition">Inicio</a></li>
                <li><a href="/busqueda" class="hover:text-white transition">Tienda</a></li>
                <li><a href="/contacto" class="hover:text-white transition">Contacto</a></li>
                <li><a href="/preguntas-frecuentes" class="hover:text-white transition">Preguntas frecuentes</a></li>
            </ul>
        </div>

        <!-- Categorías o ayuda -->
        <div>
            <h3 class="text-lg font-semibold mb-4">Ayuda</h3>
            <ul class="space-y-2 text-gray-400">
                <li><a href="/politica-envios" class="hover:text-white transition">Política de envíos</a></li>
                <li><a href="/devoluciones" class="hover:text-white transition">Devoluciones</a></li>
                <li><a href="/terminos" class="hover:text-white transition">Términos y condiciones</a></li>
                <li><a href="/aviso-legal" class="hover:text-white transition">Aviso legal</a></li>
            </ul>
        </div>

        <!-- Sobre el proyecto -->
        <div>
            <h3 class="text-lg font-semibold mb-4">Proyecto</h3>
            <ul class="space-y-2 text-gray-400">
                <li><a href="https://github.com/luisjj12/portfolio" target="_blank" rel="noopener" class="hover:text-white transition">Código en GitHub</a></li>
            </ul>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="border-t border-gray-700 py-4 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} MiTienda. Todos los derechos reservados.
    </div>
</footer>

</html>
