@section('title', 'Mis Favoritos — MiTienda')

<x-app-layout>
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 pt-24 pb-16">
            <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
                <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
                <span class="mx-1.5">/</span>
                <span class="text-gray-900">Mis Favoritos</span>
            </nav>

            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-black italic tracking-tighter text-gray-900">Mis Favoritos</h1>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Productos que has guardado</p>
            </div>

            @if($productos->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($productos as $producto)
                        <x-producto-card :producto="$producto" :esFavorito="true" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    <h2 class="text-gray-900 font-bold text-lg mb-1">Aún no tienes favoritos</h2>
                    <p class="text-gray-400 text-sm mb-6">Pulsa el corazón de cualquier producto para guardarlo aquí.</p>
                    <a href="/busqueda" class="inline-flex items-center gap-2 bg-gray-900 text-white font-black uppercase text-xs tracking-widest px-6 py-3 rounded-2xl hover:bg-black transition-all">
                        Explorar productos
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
