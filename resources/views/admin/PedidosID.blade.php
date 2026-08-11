<div id="contenedorDetalle" class="max-w-screen-2xl mx-auto p-4 sm:p-8">

    <!-- Encabezado de orden -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Orden #{{ $orden }}</h1>
            <div class="mt-1 flex items-center gap-3">
                @php
                    $coloresPago = [
                        'pendiente' => 'bg-amber-100 text-amber-700',
                        'fallo' => 'bg-red-100 text-red-700',
                        'cancelado' => 'bg-slate-100 text-slate-600',
                        'pagado' => 'bg-emerald-100 text-emerald-700',
                    ];
                    $clasePago = $coloresPago[$pago->pago] ?? 'bg-slate-100 text-slate-600';

                    $coloresEstado = [
                        'pendiente' => 'bg-amber-100 text-amber-700',
                        'enviado' => 'bg-sky-100 text-sky-700',
                        'entregado' => 'bg-emerald-100 text-emerald-700',
                        'cancelado' => 'bg-slate-100 text-slate-600',
                    ];
                    $claseEstado = $coloresEstado[$pago->estado] ?? 'bg-slate-100 text-slate-600';
                @endphp
                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $clasePago }}">{{ ucfirst($pago->pago) }}</span>
                <select id="selectEstadoPedido" data-pedido-id="{{ $pago->pedido_id }}"
                        class="text-xs font-semibold px-3 py-1 pr-6 rounded-full border-0 cursor-pointer focus:ring-2 focus:ring-indigo-400 {{ $claseEstado }}">
                    @foreach(['pendiente' => 'Pendiente', 'enviado' => 'Enviado', 'entregado' => 'Entregado', 'cancelado' => 'Cancelado'] as $valor => $etiqueta)
                        <option value="{{ $valor }}" {{ $pago->estado === $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                    @endforeach
                </select>
            </div>
            <p class="text-gray-500 text-sm mt-1">
                {{ \Carbon\Carbon::parse($pago->created_at)->format('M d, Y, h:i A') }}
            </p>
        </div>
        <button type="button" id="btnBorrar" data-order-id="{{$pago->pedido_id}}" class="bg-red-100 text-red-600 text-sm font-semibold px-4 py-2 rounded hover:bg-red-200 transition inline-block text-center">
            Eliminar pedido
        </button>

    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Detalles del pedido -->
        <div class="bg-white rounded-lg border shadow-sm p-6 w-full lg:flex-1 overflow-x-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Detalles del pedido</h2>
            </div>

            <table class="w-full min-w-[600px] text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-500 uppercase text-xs border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">Producto</th>
                        <th class="px-4 py-3 text-right">Precio</th>
                        <th class="px-4 py-3 text-center">Cantidad</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-4 flex items-center gap-3">
                            <img src="/{{ $pedido->productos->imagen }}" alt="Producto"
                                class="w-10 h-10 rounded border object-contain" />
                            <div>
                                <div class="font-semibold">{{ $pedido->productos->nombre }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-right text-green-600 font-medium">
                            €{{ number_format($pedido->productos->precio, 2) }}
                        </td>
                        <td class="px-4 py-4 text-center">{{ $pedido->cantidad }}</td>
                        <td class="px-4 py-4 text-right font-semibold">
                            €{{ number_format($pedido->precio, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totales -->
            <div class="mt-6 text-sm text-gray-700 text-right space-y-1">
                <p><span class="text-gray-500">Subtotal:</span> <span class="font-medium">€{{ number_format($subTotal, 2) }}</span></p>
                <p><span class="text-gray-500">Descuento:</span> <span class="font-medium">€{{ number_format($sumaD, 2)}}</span></p>
                <p class="text-base font-bold">Total: €{{ number_format($descuento, 2)}}</p>
            </div>
        </div>

        <!-- Detalles del cliente y envío -->
        <div class="flex flex-col gap-6 w-full lg:w-[400px] lg:flex-shrink-0">

            <!-- Cliente -->
            <div class="bg-white rounded-lg border shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Detalles del cliente</h2>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xl font-bold">
                        {{ substr($usuarios->usuarios->nombre, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-base font-semibold text-gray-800">{{ $usuarios->usuarios->nombre }}</div>
                        <div class="flex items-center text-sm text-gray-500 mt-1 gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2 5m12-5l2 5" />
                            </svg>
                            <span>{{ $pedidos->count() }} pedidos realizados</span>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-700 space-y-2">
                    <p><strong>Email:</strong> {{ $usuarios->usuarios->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $usuarios->usuarios->telefono }}</p>
                </div>
            </div>

            <!-- Dirección de envío -->
            <div class="bg-white rounded-lg border shadow-sm p-6">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">Dirección de envío</h2>
                </div>
                <p class="text-sm text-gray-700">
                    {{ $usuarios->usuarios->calle ?? 'Sin dirección registrada' }}<br>
                    {{ $usuarios->usuarios->ciudad }}, CP {{ $usuarios->usuarios->codigo_postal }}<br>
                    {{ $usuarios->usuarios->pais }}
                </p>
            </div>
        </div>
    </div>
</div>