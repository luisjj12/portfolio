@section('title', 'Preguntas frecuentes — MiTienda')
@section('description', 'Resolvemos tus dudas sobre pedidos, pagos y envíos en MiTienda.')

<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16">
        <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">Preguntas frecuentes</span>
        </nav>

        <h1 class="text-3xl font-black italic tracking-tighter text-gray-900 mb-8">Preguntas frecuentes</h1>

        <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-gray-900 mb-1">¿Cómo hago un pedido?</h2>
                <p class="text-gray-600 text-sm">Añade los productos que quieras al carrito y pulsa en "Proceder al pago". Necesitas tener una cuenta creada e iniciar sesión.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-gray-900 mb-1">¿Qué métodos de pago aceptáis?</h2>
                <p class="text-gray-600 text-sm">Actualmente solo aceptamos pagos a través de PayPal.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-gray-900 mb-1">¿Cuánto tarda en llegar mi pedido?</h2>
                <p class="text-gray-600 text-sm">Entre 24 y 48 horas laborables desde la confirmación del pago.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-gray-900 mb-1">¿Puedo devolver un producto?</h2>
                <p class="text-gray-600 text-sm">Sí, dispones de 14 días desde la recepción. Consulta el apartado de <a href="/devoluciones" class="text-orange-600 hover:underline">Devoluciones</a> para más detalle.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h2 class="font-bold text-gray-900 mb-1">¿Cómo me convierto en vendedor?</h2>
                <p class="text-gray-600 text-sm">Con tu cuenta iniciada, ve al menú de usuario y selecciona "Únete a Nosotros" para dar de alta tu propia tienda dentro de MiTienda.</p>
            </div>
        </div>
    </div>
</x-app-layout>
