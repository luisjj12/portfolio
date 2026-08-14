@section('title', 'Devoluciones — MiTienda')
@section('description', 'Condiciones de devolución de productos en MiTienda.')

<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16">
        <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">Devoluciones</span>
        </nav>

        <h1 class="text-3xl font-black italic tracking-tighter text-gray-900 mb-8">Devoluciones</h1>

        <div class="space-y-6 text-gray-600">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Plazo de devolución</h2>
                <p>Dispones de 14 días naturales desde la recepción del pedido para solicitar la devolución de un producto, sin necesidad de justificar el motivo, conforme a la normativa de protección al consumidor.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Cómo solicitar una devolución</h2>
                <p>Escríbenos a <a href="mailto:contacto@luis-market.es" class="text-orange-600 hover:underline">contacto@luis-market.es</a> indicando el número de pedido y el producto que quieres devolver, y te indicaremos los siguientes pasos.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Estado del producto</h2>
                <p>El producto debe devolverse en su estado y embalaje originales, sin haber sido usado.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Reembolso</h2>
                <p>Una vez recibido y verificado el producto, el reembolso se realiza en un plazo máximo de 14 días mediante el mismo método de pago utilizado en la compra.</p>
            </div>
        </div>
    </div>
</x-app-layout>
