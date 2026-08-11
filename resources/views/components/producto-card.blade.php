@props(['producto', 'esFavorito' => null])

@php
    $favorito = $esFavorito ?? ($producto->es_favorito ?? false);
    $valoracion = floor($producto->valoracion_promedio ?? 0);
    $tieneDescuento = ($producto->descuento ?? 0) > 0;
    $precioFinal = $tieneDescuento ? $producto->precio * (1 - $producto->descuento / 100) : $producto->precio;
@endphp

<a href="/producto/detalle/{{ $producto->id }}" class="group block bg-white rounded-2xl hover:shadow-lg transition-all duration-300 overflow-hidden">
    <div class="relative aspect-square bg-gray-50 p-6 overflow-hidden">
        @if($tieneDescuento)
            <span class="absolute top-3 left-3 z-10 bg-red-500 text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wide">
                -{{ number_format($producto->descuento, 0) }}%
            </span>
        @endif

        @auth
            <button type="button" class="btn-favorito absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-sm hover:scale-110 transition-transform"
                    data-producto-id="{{ $producto->id }}"
                    onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorito(this);">
                <svg class="w-4 h-4 {{ $favorito ? 'text-red-500' : 'text-gray-400' }}" fill="{{ $favorito ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </button>
        @else
            <button type="button" class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-sm hover:scale-110 transition-transform"
                    onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ route('login') }}';">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </button>
        @endauth

        <img src="/{{ $producto->imagen }}" alt="{{ $producto->nombre }}" loading="lazy"
             class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-105">
    </div>

    <div class="p-4">
        <h3 class="text-sm font-bold text-gray-900 leading-tight truncate italic">{{ $producto->nombre }}</h3>

        <div class="flex items-center gap-1.5 mt-1.5">
            <div class="flex text-amber-400 text-xs">
                @for ($i = 0; $i < 5; $i++)
                    <span>{{ $i < $valoracion ? '★' : '☆' }}</span>
                @endfor
            </div>
            <span class="text-[11px] text-gray-400 font-semibold">({{ $producto->total_valoraciones ?? 0 }})</span>
        </div>

        <div class="mt-2 flex items-baseline gap-2">
            @if($tieneDescuento)
                <span class="text-xs text-gray-400 line-through font-bold">{{ number_format($producto->precio, 2) }}€</span>
            @endif
            <span class="text-lg font-black text-gray-900 italic">{{ number_format($precioFinal, 2) }}€</span>
        </div>
    </div>
</a>
