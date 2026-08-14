@section('title', 'Aviso legal — MiTienda')
@section('description', 'Aviso legal de MiTienda.')

<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16">
        <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">Aviso legal</span>
        </nav>

        <h1 class="text-3xl font-black italic tracking-tighter text-gray-900 mb-8">Aviso legal</h1>

        <div class="space-y-6 text-gray-600">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Naturaleza del sitio</h2>
                <p>MiTienda es un proyecto personal de portfolio desarrollado por Luis Alfredo Jiménez Jerez con fines demostrativos y de aprendizaje. No constituye una actividad comercial real.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Propiedad</h2>
                <p>El código fuente de este proyecto está disponible públicamente en <a href="https://github.com/luisjj12/portfolio" target="_blank" rel="noopener" class="text-orange-600 hover:underline">GitHub</a>.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Contacto</h2>
                <p>Para cualquier consulta relacionada con este sitio, puedes escribir a <a href="mailto:contacto@luis-market.es" class="text-orange-600 hover:underline">contacto@luis-market.es</a>.</p>
            </div>
        </div>
    </div>
</x-app-layout>
