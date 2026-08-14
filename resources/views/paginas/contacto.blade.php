@section('title', 'Contacto — MiTienda')
@section('description', 'Ponte en contacto con MiTienda.')

<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16">
        <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">Contacto</span>
        </nav>

        <h1 class="text-3xl font-black italic tracking-tighter text-gray-900 mb-6">Contacto</h1>

        <p class="text-gray-600 mb-8">
            ¿Tienes alguna duda sobre un pedido, un producto o cómo funciona la web? Escríbenos y te responderemos lo antes posible.
        </p>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 flex items-center gap-4">
            <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <a href="mailto:contacto@luis-market.es" class="text-lg font-bold text-gray-900 hover:text-orange-600 transition-colors">contacto@luis-market.es</a>
            </div>
        </div>
    </div>
</x-app-layout>
