@section('title', ($palabra ? 'Resultados para "' . $palabra . '"' : 'Productos') . ' — MiTienda')
@section('description', 'Filtra productos por categoría, precio y valoración en MiTienda.')

<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="max-w-[1500px] mx-auto px-6 pt-6">
            <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">
                <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
                <span class="mx-1.5">/</span>
                <span class="text-gray-900">Productos</span>
            </nav>
        </div>
        <div class="max-w-[1500px] mx-auto px-6 pb-10">
            <div class="flex flex-col lg:flex-row gap-8">

                <aside class="w-full lg:w-72 flex-shrink-0">
                    <form method="GET" action="/busqueda" class="space-y-6 sticky top-10 max-h-[calc(100vh-3rem)] overflow-y-auto pr-1">
                        <input type="hidden" name="palabra" value="{{$palabra}}">

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="mb-8">
                                <h3 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4 border-b pb-2">Departamentos</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="categoria" value="" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ !request('categoria') ? 'checked' : '' }}>
                                        <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-blue-600 transition-colors">Todos los productos</span>
                                    </label>
                                    @foreach($categorias as $categoria)
                                        <label class="flex items-center group cursor-pointer">
                                            <input type="radio" name="categoria" value="{{$categoria->id}}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ request('categoria') == $categoria->id ? 'checked' : '' }}>
                                            <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-blue-600 transition-colors">{{$categoria->nombre}}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4 border-b pb-2">Presupuesto</h3>
                                <div class="flex gap-2 mb-4">
                                    <input type="number" id="minDisplay" class="w-1/2 border-gray-200 rounded-lg text-xs font-bold p-2 bg-gray-50 focus:ring-blue-500" placeholder="Min" value="{{ request('min', 0) }}">
                                    <input type="number" id="maxDisplay" class="w-1/2 border-gray-200 rounded-lg text-xs font-bold p-2 bg-gray-50 focus:ring-blue-500" placeholder="Max" value="{{ request('max', 1000) }}">
                                </div>
                                <div class="relative h-1 w-full bg-gray-200 rounded-full mb-4">
                                    <div id="rangeTrack" class="absolute h-full bg-blue-600 rounded-full"></div>
                                    <input type="range" id="minRange" min="0" max="1000" value="{{ request('min', 0) }}" class="absolute w-full h-1 appearance-none bg-transparent pointer-events-none z-30 cursor-pointer [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-blue-600 [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-white">
                                    <input type="range" id="maxRange" min="0" max="1000" value="{{ request('max', 1000) }}" class="absolute w-full h-1 appearance-none bg-transparent pointer-events-none z-30 cursor-pointer [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-blue-600 [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-white">
                                </div>
                                <input type="hidden" name="min" id="minActual" value="{{ request('min', 0) }}">
                                <input type="hidden" name="max" id="maxActual" value="{{ request('max', 1000) }}">
                            </div>

                            <div class="mb-8 pt-4 border-t border-gray-100">
                                <h3 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4">Valoración Mínima</h3>
                                <div class="flex flex-row-reverse justify-end gap-1">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="hidden peer" {{ request('rating') == $i ? 'checked' : '' }}>
                                        <label for="star{{$i}}" class="text-2xl text-gray-200 cursor-pointer hover:text-blue-600 peer-checked:text-blue-600 transition-colors">★</label>
                                    @endfor
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white font-black py-4 rounded-xl text-[10px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 active:scale-95">
                                Aplicar filtros
                            </button>
                        </div>
                    </form>
                </aside>

                <main class="flex-grow space-y-4">
                    @foreach($detalles as $value)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                        <a href="/producto/detalle/{{$value->id}}" class="flex flex-col md:flex-row p-5 gap-8 items-stretch">
                            
                            <div class="w-full md:w-56 h-56 flex-shrink-0 relative bg-white border border-gray-50 rounded-lg overflow-hidden p-4">
                                <div class="absolute top-2 left-2 flex flex-col gap-1 z-10">
                                    @if($value->valoracion_promedio >= 4.5)
                                        <span class="bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded shadow-sm uppercase italic">Top Ventas</span>
                                    @endif
                                    @if($value->created_at && $value->created_at->gt(now()->subDays(30)))
                                        <span class="bg-blue-600 text-white text-[9px] font-black px-2 py-0.5 rounded shadow-sm uppercase">Nuevo</span>
                                    @endif
                                </div>
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
                                <img src="/{{ $value->imagen }}" alt="{{$value->nombre}}" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110" />
                            </div>

                            <div class="flex-grow py-2">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex text-amber-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="text-sm">{{ $i <= floor($value->valoracion_promedio) ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                    <span class="text-xs font-bold text-gray-400">({{ number_format($value->valoracion_promedio, 1) }})</span>
                                </div>

                                <h2 class="text-xl font-extrabold text-gray-900 group-hover:text-blue-600 transition-colors leading-tight mb-4">
                                    {{$value->nombre}}
                                </h2>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-3 gap-x-6 text-[11px] border-t border-gray-50 pt-4">
                                    <div>
                                        <p class="text-gray-400 uppercase font-bold">Categoría</p>
                                        <p class="text-gray-700 font-extrabold truncate">{{ $value->categoria->nombre ?? 'General' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400 uppercase font-bold">Disponibilidad</p>
                                        @if($value->stock > 0)
                                            <p class="text-green-600 font-extrabold">✓ En Stock</p>
                                        @else
                                            <p class="text-red-600 font-extrabold">✗ Agotado</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-gray-400 uppercase font-bold">Envío</p>
                                        <p class="text-blue-600 font-extrabold italic font-serif">Express 24h</p>
                                    </div>
                                    <div class="col-span-2 sm:col-span-3">
                                        <p class="text-gray-400 uppercase font-bold">Garantía</p>
                                        <p class="text-gray-700 font-extrabold">3 años de protección oficial</p>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-64 flex flex-col justify-between border-t md:border-t-0 md:border-l border-gray-100 pt-5 md:pt-0 md:pl-8 bg-gray-50/50 md:bg-transparent -m-5 md:m-0 p-5 md:p-0">
                                <div class="text-right">
                                    @if(($value->descuento ?? 0) > 0)
                                        <span class="text-sm text-gray-400 line-through font-bold tracking-tighter">€{{ number_format($value->precio, 2) }}</span>
                                        <div class="flex items-center justify-end gap-2">
                                            <span class="bg-red-50 text-red-600 text-[10px] font-black px-1.5 py-0.5 rounded border border-red-100">-{{ number_format($value->descuento, 0) }}%</span>
                                            <p class="text-4xl font-black text-gray-900 tracking-tighter italic">€{{ number_format($value->precio * (1 - $value->descuento / 100), 2) }}</p>
                                        </div>
                                    @else
                                        <p class="text-4xl font-black text-gray-900 tracking-tighter italic">€{{ number_format($value->precio, 2) }}</p>
                                    @endif
                                    <p class="text-[9px] font-bold text-gray-500 uppercase mt-2">IVA Incluido / Envío gratis</p>
                                </div>

                                <div class="space-y-2 mt-6">
                                    @auth
                                    <button type="button" class="btn-add-carrito w-full bg-blue-600 text-white font-black py-3 rounded-lg text-xs uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-blue-700 transition-all shadow-md" data-producto-id="{{ $value->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        Añadir al carrito
                                    </button>
                                    @else
                                    <button type="button" onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ route('login') }}'" class="w-full bg-gray-900 text-white font-black py-3 rounded-lg text-xs uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-black transition-all shadow-md">
                                        Inicia sesión para comprar
                                    </button>
                                    @endauth
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
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
        
        // Sincronizar si escriben en los cuadritos
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