@section('title', 'Tus pedidos — MiTienda')

<x-app-layout>

    <div class="max-w-5xl mx-auto px-4 py-8">

        <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">
            <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-900">Tus pedidos</span>
        </nav>

        <h1 class="text-2xl font-bold text-gray-900 mb-1">Tus pedidos</h1>
        <p class="text-sm text-gray-500 mb-6">Revisa el historial completo de tus compras</p>

        @forelse($pedidos as $pedidoId => $items)
            <div class="bg-white border border-gray-300 rounded-lg mb-5 overflow-hidden shadow-sm">

                <div class="bg-gray-100 border-b border-gray-300 flex flex-wrap items-center justify-between gap-3 px-6 py-3">
                    <div class="flex flex-col text-xs text-gray-500 min-w-[110px]">
                        <span>FECHA DEL PEDIDO</span>
                        <strong class="text-sm text-gray-900 font-semibold">{{ $items->first()->created_at->format('d M Y') }}</strong>
                    </div>
                    <div class="flex flex-col text-xs text-gray-500 min-w-[110px]">
                        <span>TOTAL</span>
                        <strong class="text-sm text-gray-900 font-semibold">€{{ number_format($items->sum('precio'), 2) }}</strong>
                    </div>
                    <div class="flex flex-col text-xs text-gray-500 min-w-[110px] text-right ml-auto">
                        <span>PEDIDO #</span>
                        <strong class="text-sm text-gray-900 font-semibold">{{ $pedidoId }}</strong>
                    </div>
                </div>

                <div class="px-6 py-4">
                    <span class="inline-block text-emerald-700 text-sm font-bold mb-3">✔ {{ ucfirst($items->first()->estado) }}</span>

                    @foreach($items as $item)
                        <div class="flex flex-col sm:flex-row items-center gap-4 py-3 border-b border-gray-100 last:border-b-0">

                            <img
                                src="/{{ $item->productos->imagen }}"
                                alt="{{ $item->productos->nombre }}"
                                class="w-[72px] h-[72px] object-cover rounded-md border border-gray-300 bg-gray-50 flex-shrink-0">

                            <div class="flex-1 text-center sm:text-left">
                                <a href="/producto/detalle/{{ $item->productos->id }}" class="text-sm font-medium text-sky-700 hover:text-orange-600 hover:underline">
                                    {{ $item->productos->nombre }}
                                </a>
                                <span class="block text-sm text-gray-500">Cantidad: {{ $item->cantidad }}</span>
                            </div>

                            <div class="flex flex-row sm:flex-col gap-2 items-center sm:items-end w-full sm:w-auto">
                                <button type="button" class="btn-comprar-de-nuevo flex-1 sm:flex-none px-4 py-2 rounded-full text-sm font-medium bg-yellow-400 hover:bg-yellow-500 border border-yellow-600 text-gray-900 whitespace-nowrap transition" data-producto-id="{{ $item->productos->id }}">
                                    Comprar de nuevo
                                </button>
                                <a href="/producto/detalle/{{ $item->productos->id }}" class="flex-1 sm:flex-none px-4 py-2 rounded-full text-sm font-medium bg-gray-100 hover:bg-gray-200 border border-gray-400 text-gray-900 whitespace-nowrap transition text-center">
                                    Ver detalle
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        @empty
            <div class="text-center bg-white border border-gray-300 rounded-lg py-16 px-5 text-gray-500">
                <h2 class="text-gray-900 font-semibold text-lg mb-2">Aún no tienes compras</h2>
                <p>Cuando realices un pedido, aparecerá aquí.</p>
            </div>
        @endforelse

    </div>

    <script>
        document.querySelectorAll('.btn-comprar-de-nuevo').forEach(function(btn) {
            btn.addEventListener('click', function() {
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
