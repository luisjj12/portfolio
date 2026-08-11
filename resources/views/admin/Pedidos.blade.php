<div id="contenedorTabla" style="display: block;">
    <div class="bg-white rounded-lg border border-gray-100 p-4 sm:p-6">

        <!-- Vista tabla (md en adelante) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-base border border-gray-100 rounded-lg overflow-hidden">
                <thead class="bg-gray-50/50 text-gray-500 uppercase text-sm border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-4">Orden</th>
                        <th class="px-4 py-4">Fecha</th>
                        <th class="px-4 py-4">Clientes</th>
                        <th class="px-4 py-4">Pago</th>
                        <th class="px-4 py-4">Estado</th>
                        <th class="px-4 py-4">Método</th>
                        <th class="px-4 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-900 text-[15px]">
                    @foreach($pedidos as $producto)
                    <tr class="btnPedidoID border-t border-gray-100 hover:bg-gray-50/50 transition-colors cursor-pointer" data-pedido-id="{{ $producto->pedido_id }}">
                        <td class="px-4 py-4 text-indigo-600 font-medium font-mono-num">
                            #{{ $producto->pedido_id }}
                        </td>
                        <td class="px-4 py-4 text-slate-600">{{ \Carbon\Carbon::parse($producto->created_at)->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-semibold uppercase text-lg flex-shrink-0">
                                    {{ strtoupper(substr($producto->usuarios->nombre, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-gray-900 truncate">{{ $producto->usuarios->nombre }}</div>
                                    <div class="text-sm text-slate-400 truncate">{{ $producto->usuarios->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @php
                            $coloresPago = [
                            'pendiente' => 'bg-amber-100 text-amber-700',
                            'fallo' => 'bg-red-100 text-red-700',
                            'cancelado' => 'bg-slate-100 text-slate-600',
                            'pagado' => 'bg-emerald-100 text-emerald-700'
                            ];
                            $clasePago = $coloresPago[$producto->pago] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 text-sm rounded-full font-semibold {{ $clasePago }}">
                                {{ ucfirst($producto->pago) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            @php
                            $coloresEstado = [
                            'pendiente' => 'bg-amber-100 text-amber-700',
                            'enviado' => 'bg-sky-100 text-sky-700',
                            'entregado' => 'bg-emerald-100 text-emerald-700',
                            'cancelado' => 'bg-slate-100 text-slate-600',
                            ];
                            $claseEstado = $coloresEstado[$producto->estado] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 text-sm rounded-full font-semibold {{ $claseEstado }}">
                                {{ ucfirst($producto->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5 text-base text-slate-600">
                                <img src="https://img.icons8.com/color/24/paypal.png" alt="PayPal" class="w-5 h-5" />
                                PayPal
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <button onclick="event.stopPropagation()" class="text-slate-400 hover:text-indigo-600 text-xl transition-colors">
                                ⋮
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Vista tarjetas (móvil, por debajo de md) -->
        <div class="md:hidden space-y-3">
            @foreach($pedidos as $producto)
            <div class="btnPedidoID border border-gray-100 rounded-lg p-4 cursor-pointer hover:bg-gray-50/50 transition-colors" data-pedido-id="{{ $producto->pedido_id }}">
                <div class="flex items-center justify-between gap-3 mb-3">
                    <span class="text-indigo-600 font-medium font-mono-num">
                        #{{ $producto->pedido_id }}
                    </span>
                    <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($producto->created_at)->format('d M Y, H:i') }}</span>
                </div>

                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-semibold uppercase text-lg flex-shrink-0">
                        {{ strtoupper(substr($producto->usuarios->nombre, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="font-semibold text-gray-900 truncate">{{ $producto->usuarios->nombre }}</div>
                        <div class="text-sm text-slate-400 truncate">{{ $producto->usuarios->email }}</div>
                    </div>
                </div>

                <div class="ledger-divider pt-3 flex flex-wrap items-center gap-2">
                    @php
                    $coloresPago = [
                    'pendiente' => 'bg-amber-100 text-amber-700',
                    'fallo' => 'bg-red-100 text-red-700',
                    'cancelado' => 'bg-slate-100 text-slate-600',
                    'pagado' => 'bg-emerald-100 text-emerald-700'
                    ];
                    $clasePago = $coloresPago[$producto->pago] ?? 'bg-slate-100 text-slate-600';

                    $coloresEstado = [
                    'pendiente' => 'bg-amber-100 text-amber-700',
                    'enviado' => 'bg-sky-100 text-sky-700',
                    'entregado' => 'bg-emerald-100 text-emerald-700',
                    'cancelado' => 'bg-slate-100 text-slate-600',
                    ];
                    $claseEstado = $coloresEstado[$producto->estado] ?? 'bg-slate-100 text-slate-600';
                    @endphp
                    <span class="px-3 py-1 text-xs rounded-full font-semibold {{ $clasePago }}">
                        {{ ucfirst($producto->pago) }}
                    </span>
                    <span class="px-3 py-1 text-xs rounded-full font-semibold {{ $claseEstado }}">
                        {{ ucfirst($producto->estado) }}
                    </span>
                    <div class="flex items-center gap-1.5 text-xs text-slate-600 ml-auto">
                        <img src="https://img.icons8.com/color/24/paypal.png" alt="PayPal" class="w-4 h-4" />
                        PayPal
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    <div id="contenedorProductos" style="display: none;"></div>

</div>