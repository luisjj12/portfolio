@section('title', $detalles->nombre . ' — MiTienda')
@section('description', \Illuminate\Support\Str::limit($detalles->descripcion, 150))

<x-app-layout>
    <div class="bg-white min-h-screen pb-20">
        <nav class="max-w-7xl mx-auto px-6 pt-24 pb-4 text-xs font-bold uppercase tracking-widest text-gray-400">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <a href="/busqueda" class="hover:text-gray-900 transition-colors">Productos</a>
            @if($detalles->categoria)
                <span class="mx-1.5">/</span>
                <a href="/busqueda?categoria={{ $detalles->categoria->id }}" class="hover:text-gray-900 transition-colors">{{ $detalles->categoria->nombre }}</a>
            @endif
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">{{$detalles->nombre}}</span>
        </nav>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Imagen --}}
                <div class="lg:col-span-5">
                    <div class="lg:sticky lg:top-24 relative bg-gray-50 rounded-xl border border-gray-200 aspect-square flex items-center justify-center p-8">
                        @if(($detalles->descuento ?? 0) > 0)
                            <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wide">
                                -{{ number_format($detalles->descuento, 0) }}%
                            </span>
                        @endif
                        <img src="/{{ $detalles->imagen }}" alt="{{$detalles->nombre}}"
                             class="max-h-[85%] max-w-[85%] object-contain">
                    </div>
                </div>

                {{-- Info --}}
                <div class="lg:col-span-4">
                    <h1 class="text-2xl font-bold text-gray-900 leading-snug mb-1.5">
                        {{$detalles->nombre}}
                    </h1>

                    <a href="#opiniones" class="flex items-center gap-2 w-fit mb-4 hover:opacity-70 transition-opacity">
                        <div class="flex text-amber-400 text-sm">
                            @for ($i = 0; $i < 5; $i++)
                                <span>{{ $i < $media ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <span class="text-sm text-blue-700 underline underline-offset-2">{{ count($comentarios) }} opiniones</span>
                    </a>

                    <div class="border-t border-gray-100 pt-4 mb-4">
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{$detalles->descripcion}}
                        </p>
                    </div>

                    <ul class="space-y-2 border-t border-gray-100 pt-4">
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            Envío gratis en 24-48h
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            Garantía del fabricante de 3 años
                        </li>
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            Pago 100% seguro vía PayPal
                        </li>
                    </ul>
                </div>

                {{-- Caja de compra --}}
                <div class="lg:col-span-3">
                    <div class="lg:sticky lg:top-24 border border-gray-200 rounded-xl p-5 space-y-4">
                        <div>
                            @if(($detalles->descuento ?? 0) > 0)
                                <p class="text-sm text-gray-400 line-through font-semibold">€{{ number_format($detalles->precio, 2) }}</p>
                                <p class="text-3xl font-black text-gray-900 tracking-tight">€{{ number_format($detalles->precio * (1 - $detalles->descuento / 100), 2) }}</p>
                            @else
                                <p class="text-3xl font-black text-gray-900 tracking-tight">€{{ number_format($detalles->precio, 2) }}</p>
                            @endif
                        </div>

                        @if($totales > 0)
                            <p class="text-sm font-bold text-emerald-600">En stock</p>
                        @else
                            <p class="text-sm font-bold text-red-500">Agotado</p>
                        @endif

                        <div class="space-y-2 pt-1">
                            @auth
                                <button id="addToCart"
                                        data-producto-id="{{$detalles->id}}"
                                        class="w-full bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold py-3 rounded-full transition-all active:scale-95 text-sm">
                                    Añadir al carrito
                                </button>

                                <a href="/pagar"
                                   class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 rounded-full transition-all block text-center text-sm">
                                    Comprar ahora
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 rounded-full transition-all block text-center text-sm">
                                    Inicia sesión para comprar
                                </a>
                            @endauth
                        </div>

                        <p class="text-[11px] text-center text-gray-400 pt-1">
                            Pago seguro con PayPal
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- También te puede interesar (a todo lo ancho de la pantalla) --}}
        @if($relacionados->isNotEmpty())
        <section class="mt-16 px-4">
            <h2 class="text-xl font-bold text-gray-900 mb-6 px-2">También te puede interesar</h2>

            {{-- Móvil: lista vertical, un producto por fila --}}
            <div class="sm:hidden flex flex-col gap-4 px-2">
                @foreach($relacionados as $producto)
                    <x-producto-card :producto="$producto" />
                @endforeach
            </div>

            {{-- Tablet/escritorio: carrusel --}}
            <div class="hidden sm:flex items-center gap-3">
                <button onclick="prevSlide('carousel-relacionados')" aria-label="Anterior"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-10 h-10 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>

                <div class="overflow-hidden flex-1">
                    <div id="carousel-relacionados" class="flex gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar py-1">
                        @foreach($relacionados as $producto)
                            <div class="snap-start flex-none w-[19%] lg:w-[14%] xl:w-[12%]">
                                <x-producto-card :producto="$producto" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <button onclick="nextSlide('carousel-relacionados')" aria-label="Siguiente"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-10 h-10 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </section>
        @endif

        {{-- Precio similar (a todo lo ancho de la pantalla) --}}
        @if($precioSimilar->isNotEmpty())
        <section class="mt-16 px-4">
            <h2 class="text-xl font-bold text-gray-900 mb-6 px-2">Otros productos con un precio parecido</h2>

            {{-- Móvil: lista vertical, un producto por fila --}}
            <div class="sm:hidden flex flex-col gap-4 px-2">
                @foreach($precioSimilar as $producto)
                    <x-producto-card :producto="$producto" />
                @endforeach
            </div>

            {{-- Tablet/escritorio: carrusel --}}
            <div class="hidden sm:flex items-center gap-3">
                <button onclick="prevSlide('carousel-precio')" aria-label="Anterior"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-10 h-10 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>

                <div class="overflow-hidden flex-1">
                    <div id="carousel-precio" class="flex gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar py-1">
                        @foreach($precioSimilar as $producto)
                            <div class="snap-start flex-none w-[19%] lg:w-[14%] xl:w-[12%]">
                                <x-producto-card :producto="$producto" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <button onclick="nextSlide('carousel-precio')" aria-label="Siguiente"
                    class="flex flex-shrink-0 bg-white text-gray-700 rounded-full w-10 h-10 items-center justify-center border border-gray-200 shadow-sm hover:bg-gray-50 hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </section>
        @endif

        <div class="max-w-7xl mx-auto px-6">
            {{-- Opiniones --}}
            <div id="opiniones" class="mt-16 scroll-mt-24">
                <div class="flex flex-col md:flex-row items-end justify-between mb-8 border-b border-gray-100 pb-5">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Opiniones de la comunidad</h2>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1.5">Basado en {{ count($comentarios) }} experiencias reales</p>
                    </div>
                    <a href="/comentario/{{$detalles->id}}" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-5 py-3 bg-gray-900 text-white rounded-full font-bold text-xs uppercase tracking-widest hover:bg-black transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" /></svg>
                        Escribir reseña
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 text-center lg:sticky lg:top-24">
                            <p class="text-5xl font-black text-gray-900 tracking-tight">{{ number_format($media, 1) }}</p>
                            <div class="flex justify-center text-amber-400 my-3">
                                @for ($i = 0; $i < 5; $i++)
                                    <span class="text-lg">{{ $i < $media ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ count($comentarios) }} opiniones</p>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-4">
                        @forelse($comentarios as $values)
                            @foreach($usuarios as $user)
                                @if($user->id == $values->usuario_id)
                                    <div class="bg-white p-5 rounded-xl border border-gray-100">
                                        <div class="flex items-center justify-between mb-2.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full bg-gray-900 text-white flex items-center justify-center font-bold text-sm">
                                                    {{ strtoupper(substr($user->nombre, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900 text-sm">{{ $user->nombre }}</h4>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $values->created_at->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="flex text-amber-400 text-xs">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <span>{{ $i < $values->rating ? '★' : '☆' }}</span>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $values->comentario }}</p>
                                    </div>
                                @endif
                            @endforeach
                        @empty
                            <div class="text-center py-14 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <p class="text-gray-400 font-bold">No hay opiniones todavía. ¡Sé el primero!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="w-screen max-w-md transform transition-all duration-500">
                    <div class="h-full flex flex-col bg-white shadow-2xl">
                        <div class="px-6 py-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Tu Carrito</h2>
                            <button id="closeModalBtn" class="p-2 text-gray-400 hover:text-black transition-colors">
                                <svg class="h-6 w-6 font-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div id="pintarCarrito" class="flex-1 overflow-y-auto px-6 py-4 space-y-6">
                            </div>

                        <div class="border-t border-gray-100 p-8 space-y-6 bg-gray-50">
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    <span>Artículos:</span>
                                    <span id="cantidad" class="text-gray-900">0</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="text-sm font-black text-gray-900 uppercase">Total Estimado</span>
                                    <span id="total" class="text-3xl font-black text-gray-900 tracking-tighter">€0.00</span>
                                </div>
                            </div>
                            <a href="/pagar" class="w-full bg-gray-900 hover:bg-black text-white font-black py-5 rounded-full transition-all uppercase text-xs tracking-[0.2em] block text-center">
                                Finalizar Pedido
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Se expone globalmente para que el manejador de "quitar del carrito" de navigation.blade.php
        // pueda refrescar este mismo modal tras borrar un producto.
        window.mostrarCarritoProducto = function(items) {
            window.pintarItemsCarrito(items, {
                container: document.getElementById('pintarCarrito'),
                totalEl: document.getElementById('total'),
                cantidadEl: document.getElementById('cantidad'),
                formatTotal: t => `€${t.toFixed(2)}`,
                renderRow: (item, producto, subtotal) => `
                    <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-16 h-16 flex-shrink-0 bg-gray-50 rounded-lg p-1">
                            <img src="${producto.imagen}" class="w-full h-full object-contain">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-gray-900 leading-tight">${producto.nombre}</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mt-1">Cantidad: ${item.cantidad}</p>
                            <p class="text-sm font-black text-gray-900 mt-1">€${producto.precio}</p>
                        </div>
                        <button class="flex-shrink-0 text-gray-300 hover:text-red-500 transition-colors btn-eliminar" data-id="${item.producto_id}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                `,
            });
        };

        document.getElementById('addToCart').addEventListener('click', function() {
            const productoId = this.getAttribute('data-producto-id');

            axios.post('/producto/carro', {
                producto_id: productoId,
                cantidad: 1
            }).then(function(response) {
                document.getElementById('myModal').classList.remove('hidden');
                window.mostrarCarritoProducto(response.data.itemsPedido || []);
            }).catch(function(error) {
                alert(error.response?.data?.error || 'No se pudo añadir el producto al carrito.');
            });
        });

        // Cerrar modal
        document.getElementById('closeModalBtn').addEventListener('click', () => {
            document.getElementById('myModal').classList.add('hidden');
        });

        // Cerrar al clickar fuera (backdrop)
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('myModal');
            if (e.target.classList.contains('bg-gray-900/60')) {
                modal.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
