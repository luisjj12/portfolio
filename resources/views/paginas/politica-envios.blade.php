@section('title', 'Política de envíos — MiTienda')
@section('description', 'Información sobre plazos y condiciones de envío en MiTienda.')

<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-16">
        <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">Política de envíos</span>
        </nav>

        <h1 class="text-3xl font-black italic tracking-tighter text-gray-900 mb-8">Política de envíos</h1>

        <div class="prose prose-gray max-w-none space-y-6 text-gray-600">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Plazos de entrega</h2>
                <p>Los pedidos se envían en un plazo de 24 a 48 horas laborables desde la confirmación del pago. El tiempo de entrega puede variar según la disponibilidad del producto y la zona de destino.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Gastos de envío</h2>
                <p>El envío es gratuito en todos los pedidos, sin importe mínimo de compra.</p>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Seguimiento del pedido</h2>
                <p>Puedes consultar el estado de tus pedidos en cualquier momento desde el apartado "Tus pedidos" de tu cuenta.</p>
            </div>
        </div>
    </div>
</x-app-layout>
