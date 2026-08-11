<!-- Contenedor principal del contenido -->
    <div class="px-4 sm:px-8 lg:px-10 mx-auto max-w-full">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 font-sans">
            <h2 class="text-xl font-display font-semibold text-gray-900">Productos</h2>
        </div>

        <!-- Tabla con scroll si es necesario -->
        <div id="contenedorTablaProductos">

            <!-- Vista tabla (md en adelante) -->
            <div class="hidden md:block w-full overflow-x-auto bg-white border border-gray-100 rounded-lg">
                <table class="min-w-[1100px] w-full border-collapse text-sm">
                    <thead class="bg-gray-50/50 text-gray-500 uppercase text-xs border-b border-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left rounded-tl-lg">Imagen</th>
                            <th class="px-4 py-3 text-left">Producto</th>
                            <th class="px-4 py-3 text-center">Categoría</th>
                            <th class="px-4 py-3 text-center">Precio</th>
                            <th class="px-4 py-3 text-center">Cantidad</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-center rounded-tr-lg">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3">
                                <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/36' }}" alt="Producto"
                                    class="w-14 h-14 object-contain rounded-md border border-gray-100 bg-white" />
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $producto->nombre ?? 'Producto de ejemplo' }}</div>
                                <div class="text-xs text-slate-400">{{ $producto->descripcion ?? 'Sin descripción' }}</div>
                            </td>
                            <td class="px-4 py-3 text-center text-slate-600">{{ $producto->categoria->nombre ?? 'Categoría X' }}</td>
                            <td class="px-4 py-3 text-center font-mono-num">
                                @if(($producto->descuento ?? 0) > 0)
                                    <div class="text-emerald-700 font-semibold">${{ number_format($producto->precio * (1 - $producto->descuento / 100), 2) }}</div>
                                    <div class="text-slate-400 line-through text-xs">${{ number_format($producto->precio, 2) }}</div>
                                @else
                                    <span class="text-emerald-700 font-semibold">${{ number_format($producto->precio ?? 0, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-slate-600 font-mono-num">{{ $producto->stock }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($producto->stock == 0)
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">NO STOCK</span>
                                @else
                                <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-semibold">STOCK</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex items-center gap-3">
                                    <a href="javascript:void(0)" class="btn-editar-producto text-slate-400 hover:text-indigo-600 transition-colors" data-id="{{ $producto->id }}">
                                        <i class='bx bx-edit text-lg'></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn-borrar-producto text-slate-400 hover:text-red-600 transition-colors"
                                        data-id="{{ $producto->id }}"
                                        data-nombre="{{ $producto->nombre }}">
                                        <i class='bx bx-trash text-lg'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Vista tarjetas (móvil, por debajo de md) -->
            <div class="md:hidden space-y-3">
                @foreach($productos as $producto)
                <div class="bg-white border border-gray-100 rounded-lg p-4">
                    <div class="flex items-start gap-3 mb-3">
                        <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/36' }}" alt="Producto"
                            class="w-14 h-14 object-contain rounded-md border border-gray-100 bg-white flex-shrink-0" />
                        <div class="min-w-0 flex-1">
                            <div class="font-medium text-gray-900 truncate">{{ $producto->nombre ?? 'Producto de ejemplo' }}</div>
                            <div class="text-xs text-slate-400 line-clamp-2">{{ $producto->descripcion ?? 'Sin descripción' }}</div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <a href="javascript:void(0)" class="btn-editar-producto text-slate-400 hover:text-indigo-600 transition-colors" data-id="{{ $producto->id }}">
                                <i class='bx bx-edit text-lg'></i>
                            </a>
                            <a href="javascript:void(0)"
                                class="btn-borrar-producto text-slate-400 hover:text-red-600 transition-colors"
                                data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->nombre }}">
                                <i class='bx bx-trash text-lg'></i>
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs">
                        <span class="text-slate-600">{{ $producto->categoria->nombre ?? 'Categoría X' }}</span>
                        @if(($producto->descuento ?? 0) > 0)
                            <span class="text-emerald-700 font-semibold font-mono-num">${{ number_format($producto->precio * (1 - $producto->descuento / 100), 2) }}</span>
                            <span class="text-slate-400 line-through font-mono-num">${{ number_format($producto->precio, 2) }}</span>
                        @else
                            <span class="text-emerald-700 font-semibold font-mono-num">${{ number_format($producto->precio ?? 0, 2) }}</span>
                        @endif
                        <span class="text-slate-600 font-mono-num">Stock: {{ $producto->stock }}</span>
                        @if($producto->stock == 0)
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full font-semibold">NO STOCK</span>
                        @else
                        <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full font-semibold">STOCK</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pagination mt-4">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
