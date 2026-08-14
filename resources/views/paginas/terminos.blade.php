@section('title', 'Términos y condiciones — MiTienda')
@section('description', 'Términos y condiciones de uso de MiTienda.')

<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16">
        <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">Términos y condiciones</span>
        </nav>

        <h1 class="text-3xl font-black italic tracking-tighter text-gray-900 mb-8">Términos y condiciones</h1>

        <div class="space-y-6 text-gray-600">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Sobre este proyecto</h2>
                <p>MiTienda es un proyecto de portfolio personal desarrollado con fines demostrativos y de aprendizaje. No es una tienda comercial real, aunque su funcionamiento (registro, catálogo, carrito y pago) es completamente funcional.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Uso de la web</h2>
                <p>Al registrarte y usar esta web te comprometes a facilitar información veraz y a hacer un uso adecuado del sitio, sin intentar dañar su funcionamiento ni el de otros usuarios.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Cuentas de usuario</h2>
                <p>Eres responsable de mantener la confidencialidad de tu contraseña y de toda la actividad que ocurra en tu cuenta.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Pagos</h2>
                <p>Los pagos se procesan a través de PayPal. MiTienda no almacena datos de tarjetas ni de cuentas bancarias.</p>
            </div>
        </div>
    </div>
</x-app-layout>
