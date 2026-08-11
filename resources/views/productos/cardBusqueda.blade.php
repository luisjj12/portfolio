@section('title', 'Resultados para "' . $palabra . '" — MiTienda')
@section('description', 'Resultados de búsqueda para "' . $palabra . '" en MiTienda.')

<x-app-layout>
    <div class="bg-slate-50 min-h-screen font-sans">

        <nav class="max-w-[1500px] mx-auto px-6 pt-6 text-xs font-bold uppercase tracking-widest text-slate-400">
            <a href="/" class="hover:text-slate-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-slate-900">Búsqueda</span>
        </nav>

        <!-- Barra de resultados -->
        <div class="bg-white border-b border-slate-200 sticky top-0 z-20">
            <div class="max-w-[1500px] mx-auto px-6 py-3 flex items-center gap-3 text-sm">
                <span class="text-slate-500">Resultados para</span>
                <span class="font-extrabold text-slate-900">"{{ $palabra }}"</span>
            </div>
        </div>

        <div class="max-w-[1500px] mx-auto px-6 py-6">
            <div class="flex flex-col lg:flex-row gap-6">

                <!-- SIDEBAR FILTROS -->
                <aside class="w-full lg:w-72 flex-shrink-0">
                    <form method="GET" action="/busqueda" class="space-y-4 sticky top-20 max-h-[calc(100vh-7rem)] overflow-y-auto pr-1">
                        <input type="hidden" name="palabra" value="{{ $palabra }}">

                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                            <div class="p-5 space-y-6">
                                <!-- Departamentos -->
                                <div>
                                    <h4 class="text-[11px] font-black uppercase tracking-widest text-slate-900 mb-3 flex items-center gap-2">
                                        <span class="w-1 h-3 bg-blue-600 rounded-full"></span>Departamentos
                                    </h4>
                                    <div class="space-y-1.5">
                                        <label class="flex items-center group cursor-pointer p-1.5 rounded-md hover:bg-blue-50 transition-colors">
                                            <input type="radio" name="categoria" value="" class="w-4 h-4 accent-blue-600 border-slate-300" {{ !request('categoria') ? 'checked' : '' }}>
                                            <span class="ml-3 text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">Todos los productos</span>
                                        </label>
                                        @foreach($categorias as $categoria)
                                            <label class="flex items-center group cursor-pointer p-1.5 rounded-md hover:bg-blue-50 transition-colors {{ request('categoria') == $categoria->id ? 'bg-blue-50' : '' }}">
                                                <input type="radio" name="categoria" value="{{ $categoria->id }}" class="w-4 h-4 accent-blue-600 border-slate-300" {{ request('categoria') == $categoria->id ? 'checked' : '' }}>
                                                <span class="ml-3 text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition-colors {{ request('categoria') == $categoria->id ? 'text-blue-600' : '' }}">{{ $categoria->nombre }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <hr class="border-slate-100">

                                <!-- Presupuesto -->
                                <div>
                                    <h4 class="text-[11px] font-black uppercase tracking-widest text-slate-900 mb-3 flex items-center gap-2">
                                        <span class="w-1 h-3 bg-blue-600 rounded-full"></span>Presupuesto
                                    </h4>
                                    <div class="flex gap-2 mb-4">
                                        <div class="flex-1 relative">
                                            <span class="absolute left-2 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">€</span>
                                            <input type="number" id="minDisplay" class="w-full border border-slate-300 rounded-lg text-sm font-bold pl-6 pr-2 py-2 bg-slate-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Min" value="{{ request('min', 0) }}">
                                        </div>
                                        <div class="flex-1 relative">
                                            <span class="absolute left-2 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">€</span>
                                            <input type="number" id="maxDisplay" class="w-full border border-slate-300 rounded-lg text-sm font-bold pl-6 pr-2 py-2 bg-slate-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Max" value="{{ request('max', 1000) }}">
                                        </div>
                                    </div>
                                    <div class="relative h-2 w-full bg-slate-200 rounded-full mb-2">
                                        <div id="rangeTrack" class="absolute h-full bg-blue-600 rounded-full"></div>
                                        <input type="range" id="minRange" min="0" max="1000" value="{{ request('min', 0) }}" class="absolute w-full h-2 appearance-none bg-transparent pointer-events-none z-30 cursor-pointer [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-blue-600 [&::-webkit-slider-thumb]:shadow-md">
                                        <input type="range" id="maxRange" min="0" max="1000" value="{{ request('max', 1000) }}" class="absolute w-full h-2 appearance-none bg-transparent pointer-events-none z-30 cursor-pointer [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-blue-600 [&::-webkit-slider-thumb]:shadow-md">
                                    </div>
                                    <input type="hidden" name="min" id="minActual" value="{{ request('min', 0) }}">
                                    <input type="hidden" name="max" id="maxActual" value="{{ request('max', 1000) }}">
                                </div>

                                <hr class="border-slate-100">

                                <!-- Valoración -->
                                
                            <div class="mb-8 pt-4 border-t border-gray-100">
                                <h3 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4">Valoración Mínima</h3>
                                <div class="flex flex-row-reverse justify-end gap-1">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="hidden peer" {{ request('rating') == $i ? 'checked' : '' }}>
                                        <label for="star{{$i}}" class="text-2xl text-gray-200 cursor-pointer hover:text-blue-600 peer-checked:text-blue-600 transition-colors">★</label>
                                    @endfor
                                </div>
                            </div>
                                <button type="submit" class="w-full bg-blue-600 text-white font-black py-3.5 rounded-lg text-xs uppercase tracking-widest hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200 hover:-translate-y-0.5 transition-all active:scale-95">
                                    Aplicar filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </aside>

                <!-- RESULTADOS -->
                <main class="flex-grow space-y-4">
                    @forelse($detalles as $value)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300 group relative overflow-hidden">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>

                        <a href="/producto/detalle/{{ $value->id }}" class="flex flex-col md:flex-row p-6 gap-6 items-stretch">

                            <!-- Imagen -->
                            <div class="w-full md:w-56 h-56 flex-shrink-0 relative bg-slate-50 group-hover:bg-blue-50/40 transition-colors border border-slate-100 rounded-xl overflow-hidden p-6 flex items-center justify-center">
                                @if($value->valoracion_promedio >= 4.5)
                                <span class="absolute top-2 left-2 bg-amber-500 text-white text-[9px] font-black px-2 py-0.5 rounded shadow-sm uppercase z-10">Top Ventas</span>
                                @endif
                                @auth
                                <button type="button" class="btn-favorito absolute top-2 right-2 z-10 w-8 h-8 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-sm hover:scale-110 transition-transform"
                                        data-producto-id="{{ $value->id }}"
                                        onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorito(this);">
                                    <svg class="w-4 h-4 {{ $value->es_favorito ? 'text-red-500' : 'text-gray-400' }}" fill="{{ $value->es_favorito ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                                @else
                                <button type="button" class="absolute top-2 right-2 z-10 w-8 h-8 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-sm hover:scale-110 transition-transform"
                                        onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ route('login') }}';">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                                @endauth
                                <img src="/{{ $value->imagen }}" alt="{{ $value->nombre }}" class="max-w-full max-h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-105" loading="lazy" />
                            </div>

                            <!-- Info central -->
                            <div class="flex-grow py-1 min-w-0 flex flex-col">
                                <!-- Valoración (solo si hay reseñas) -->
                                @if($value->valoracion_promedio > 0)
                                <div class="flex items-center gap-2 mb-1.5">
                                    <div class="flex text-amber-400 text-sm">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span>{{ $i <= floor($value->valoracion_promedio) ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                    <span class="text-xs font-bold text-slate-500">{{ number_format($value->valoracion_promedio, 1) }}</span>
                                </div>
                                @else
                                <div class="mb-1.5">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Sin reseñas aún</span>
                                </div>
                                @endif

                                <!-- Nombre (protagonista) -->
                                <h2 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-snug mb-2 line-clamp-2">
                                    {{ $value->nombre }}
                                </h2>

                                <!-- Atributos como chips -->
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="bg-slate-50 border border-slate-200 rounded-md px-2.5 py-1 text-xs">
                                        <span class="font-bold text-slate-400 uppercase text-[9px] block leading-none mb-0.5">Categoría</span>
                                        <span class="font-bold text-slate-700">{{ $value->categoria->nombre ?? 'General' }}</span>
                                    </span>
                                    @if($value->stock > 0)
                                        <span class="bg-emerald-50 border border-emerald-100 rounded-md px-2.5 py-1 text-xs">
                                            <span class="font-bold text-emerald-500 uppercase text-[9px] block leading-none mb-0.5">Stock</span>
                                            <span class="font-bold text-emerald-700">Disponible</span>
                                        </span>
                                    @else
                                        <span class="bg-red-50 border border-red-100 rounded-md px-2.5 py-1 text-xs">
                                            <span class="font-bold text-red-500 uppercase text-[9px] block leading-none mb-0.5">Stock</span>
                                            <span class="font-bold text-red-700">Agotado</span>
                                        </span>
                                    @endif
                                    <span class="bg-slate-50 border border-slate-200 rounded-md px-2.5 py-1 text-xs">
                                        <span class="font-bold text-slate-400 uppercase text-[9px] block leading-none mb-0.5">Envío</span>
                                        <span class="font-bold text-slate-700">24h</span>
                                    </span>
                                </div>

                                <!-- Precio + CTA en una sola fila, cerca del nombre -->
                                <div class="mt-auto flex items-end justify-between gap-4 pt-4 mt-3 border-t border-dashed border-slate-200">
                                    <div>
                                        @if(($value->descuento ?? 0) > 0)
                                        <span class="text-xs text-slate-400 line-through font-medium">€{{ number_format($value->precio, 2) }}</span>
                                        @endif
                                        <div class="flex items-baseline gap-2">
                                            <p class="text-3xl font-black text-slate-900 tracking-tighter">€{{ number_format(($value->descuento ?? 0) > 0 ? $value->precio * (1 - $value->descuento / 100) : $value->precio, 2) }}</p>
                                            @if(($value->descuento ?? 0) > 0)
                                            <span class="bg-rose-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded">-{{ number_format($value->descuento, 0) }}%</span>
                                            @endif
                                        </div>
                                        <p class="text-[10px] font-bold text-emerald-700 uppercase mt-0.5">Envío gratis</p>
                                    </div>

                                    @auth
                                    <button type="button" class="btn-add-carrito bg-blue-600 text-white font-black py-2.5 px-5 rounded-xl text-xs uppercase tracking-wider flex items-center gap-2 hover:bg-blue-700 active:scale-95 transition-all shadow-md shadow-blue-600/20 whitespace-nowrap" data-producto-id="{{ $value->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        <span class="hidden sm:inline">Añadir al carrito</span>
                                        <span class="sm:hidden">Añadir</span>
                                    </button>
                                    @else
                                    <button type="button" onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ route('login') }}'" class="bg-gray-900 text-white font-black py-2.5 px-5 rounded-xl text-xs uppercase tracking-wider flex items-center gap-2 hover:bg-black transition-all whitespace-nowrap">
                                        Inicia sesión
                                    </button>
                                    @endauth
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center">
                        <p class="text-slate-300 text-5xl mb-4">🔍</p>
                        <h3 class="text-xl font-black text-slate-900 mb-2">Sin resultados</h3>
                        <p class="text-slate-500 text-sm">No encontramos productos que coincidan con tu búsqueda. Prueba ajustar los filtros.</p>
                    </div>
                    @endforelse
                </main>
            </div>
        </div>
    </div>

    <script>
        const minR = document.getElementById('minRange');
        const maxR = document.getElementById('maxRange');
        const minD = document.getElementById('minDisplay');
        const maxD = document.getElementById('maxDisplay');
        const track = document.getElementById('rangeTrack');
        const minAct = document.getElementById('minActual');
        const maxAct = document.getElementById('maxActual');

        function sync() {
            let valMin = parseInt(minR.value);
            let valMax = parseInt(maxR.value);
            if (valMin > valMax) { minR.value = valMax; valMin = valMax; }

            minD.value = valMin;
            maxD.value = valMax;
            minAct.value = valMin;
            maxAct.value = valMax;

            const p1 = (valMin / 1000) * 100;
            const p2 = (valMax / 1000) * 100;
            track.style.left = p1 + '%';
            track.style.width = (p2 - p1) + '%';
        }

        minR.addEventListener('input', sync);
        maxR.addEventListener('input', sync);
        minD.addEventListener('change', () => { minR.value = minD.value; sync(); });
        maxD.addEventListener('change', () => { maxR.value = maxD.value; sync(); });

        sync();

        // Añadir al carrito directamente desde el listado de resultados
        document.querySelectorAll('.btn-add-carrito').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const token = document.querySelector('meta[name="csrf-token"]').content;

                fetch('/producto/carro', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({ producto_id: btn.dataset.productoId, cantidad: 1 }),
                    })
                    .then(res => res.json().then(data => ({ ok: res.ok, data })))
                    .then(({ ok, data }) => {
                        if (!ok) {
                            alert(data.error || 'No se pudo añadir el producto al carrito.');
                            return;
                        }
                        window.mostrarCarrito();
                        document.getElementById('modalCarrito').classList.remove('hidden');
                    });
            });
        });
    </script>
</x-app-layout>