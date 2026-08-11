@section('title', 'MiTienda — Todo lo que buscas, a un clic de distancia')
@section('description', 'Descubre los productos mejor valorados, las últimas novedades y las mejores ofertas, seleccionados para ti.')

<x-app-layout>
    <div class="bg-gray-50 min-h-screen">

        {{-- Hero --}}
        <section class="relative bg-gray-900 text-white overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-900 to-indigo-950"></div>
            <div class="relative max-w-7xl mx-auto px-6 py-24 sm:py-28 text-center">
                <span class="inline-block text-[11px] font-black uppercase tracking-[0.3em] text-orange-400 mb-4">Bienvenido a MiTienda</span>
                <h1 class="text-4xl sm:text-6xl font-black italic tracking-tighter mb-6">
                    Todo lo que buscas,<br class="hidden sm:block"> a un clic de distancia
                </h1>
                <p class="text-gray-400 max-w-xl mx-auto mb-10 font-medium">
                    Descubre los productos mejor valorados, las últimas novedades y las mejores ofertas, seleccionados para ti.
                </p>
                <a href="/busqueda" class="inline-flex items-center gap-2 bg-white text-gray-900 font-black uppercase text-xs tracking-widest px-8 py-4 rounded-2xl hover:bg-gray-100 transition-all shadow-xl">
                    Explorar productos
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </a>
            </div>
        </section>

        <main class="max-w-7xl mx-auto px-6 py-16 space-y-20">

            {{-- Destacados --}}
            @if($ratingD->isNotEmpty())
            <section>
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">Productos Destacados</h2>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Los mejor valorados</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($ratingD as $producto)
                        <x-producto-card :producto="$producto" />
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Más comprados --}}
            @if($opiniones->isNotEmpty())
            <section>
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">Más Comprados</h2>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Los favoritos de la comunidad</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($opiniones as $producto)
                        <x-producto-card :producto="$producto" />
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Nuevos --}}
            @if($productosR->isNotEmpty())
            <section>
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">Nuevos Productos</h2>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Recién llegados</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($productosR as $producto)
                        <x-producto-card :producto="$producto" />
                    @endforeach
                </div>
            </section>
            @endif

            {{-- En oferta --}}
            @if($productosO->isNotEmpty())
            <section>
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">En Oferta</h2>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Precios rebajados por tiempo limitado</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($productosO as $producto)
                        <x-producto-card :producto="$producto" />
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Productos para el hogar --}}
            @if($productosH->isNotEmpty())
            <section>
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">Productos para el Hogar</h2>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Todo para tu espacio</p>
                </div>

                {{-- Móvil: lista vertical, un producto por fila --}}
                <div class="sm:hidden flex flex-col gap-4">
                    @foreach($productosH as $producto)
                        <x-producto-card :producto="$producto" />
                    @endforeach
                </div>

                {{-- Tablet/escritorio: carrusel --}}
                <div class="hidden sm:flex items-center gap-3">
                    <button onclick="prevSlide('carousel-2')" aria-label="Anterior"
                        class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-11 h-11 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </button>

                    <div class="overflow-hidden flex-1">
                        <div id="carousel-2" class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar py-1">
                            @foreach($productosH as $producto)
                                <div class="snap-start flex-none w-[31%] lg:w-[23%]">
                                    <x-producto-card :producto="$producto" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button onclick="nextSlide('carousel-2')" aria-label="Siguiente"
                        class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-11 h-11 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </section>
            @endif

        </main>

        {{-- Explora más productos (a todo lo ancho de la pantalla) --}}
        @if($productosC->isNotEmpty())
        <section class="pb-16 px-4">
            <div class="mb-8 px-2">
                <h2 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">Explora Más Productos</h2>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Todo lo mejor valorado, en un solo sitio</p>
            </div>

            {{-- Móvil: lista vertical, un producto por fila --}}
            <div class="sm:hidden flex flex-col gap-4 px-2">
                @foreach($productosC as $producto)
                    @if($producto->valoracion_promedio != 0)
                        <x-producto-card :producto="$producto" />
                    @endif
                @endforeach
            </div>

            {{-- Tablet/escritorio: carrusel --}}
            <div class="hidden sm:flex items-center gap-3">
                <button onclick="prevSlide('carousel-1')" aria-label="Anterior"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-11 h-11 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>

                <div class="overflow-hidden flex-1">
                    <div id="carousel-1" class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar py-1">
                        @foreach($productosC as $producto)
                            @if($producto->valoracion_promedio != 0)
                                <div class="snap-start flex-none w-[19%] lg:w-[14%] xl:w-[12%]">
                                    <x-producto-card :producto="$producto" />
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <button onclick="nextSlide('carousel-1')" aria-label="Siguiente"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-11 h-11 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </section>
        @endif
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>
