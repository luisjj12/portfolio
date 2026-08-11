<x-app-layout>
    <div class="bg-gray-50 min-h-screen">

        <div class="max-w-md mx-auto px-6 pt-28 pb-10 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-9 w-9 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>

            <h1 class="text-lg font-black text-gray-900 mb-1">¡Gracias por tu compra!</h1>
            <p class="text-sm text-gray-500 mb-5">Tu transacción se ha procesado correctamente y tu pedido ya está en camino.</p>

            <a href="/" class="inline-block px-5 py-2 bg-gray-900 hover:bg-black text-white text-xs font-bold uppercase tracking-widest rounded-full transition-colors">
                Volver al inicio
            </a>
        </div>

        @if($productos->isNotEmpty())
        <div class="pb-20">
            <div class="px-6 mb-8">
                <h2 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">Productos que te pueden interesar</h2>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Seleccionados para ti</p>
            </div>

            {{-- Móvil: lista vertical, un producto por fila --}}
            <div class="sm:hidden flex flex-col gap-4 px-6">
                @foreach($productos as $producto)
                    <x-producto-card :producto="$producto" />
                @endforeach
            </div>

            {{-- Tablet/escritorio: carrusel a todo lo ancho de la pantalla --}}
            <div class="hidden sm:flex items-center gap-3 px-4">
                <button onclick="prevSlide('carousel-gracias')" aria-label="Anterior"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-11 h-11 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>

                <div class="overflow-hidden flex-1">
                    <div id="carousel-gracias" class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar py-1">
                        @foreach($productos as $producto)
                            <div class="snap-start flex-none w-[23%] lg:w-[18%] xl:w-[15%]">
                                <x-producto-card :producto="$producto" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <button onclick="nextSlide('carousel-gracias')" aria-label="Siguiente"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-11 h-11 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
        @endif
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>
