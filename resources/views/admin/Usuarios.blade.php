<div class="px-4 sm:px-8 lg:px-10 mx-auto max-w-full">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6 font-sans">
        <h2 class="text-xl font-display font-semibold text-gray-900">Usuarios</h2>
    </div>

    <div id="contenedorTablaUsuarios">

        <!-- Vista tabla (md en adelante) -->
        <div class="hidden md:block w-full overflow-x-auto bg-white border border-gray-100 rounded-lg">
            <table class="min-w-[1000px] w-full border-collapse text-sm">
                <thead class="bg-gray-50/50 text-gray-500 uppercase text-xs font-semibold select-none border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left rounded-tl-lg">Usuario</th>
                        <th class="px-4 py-3 text-left">Rol</th>
                        <th class="px-4 py-3 text-left">Empresa</th>
                        <th class="px-4 py-3 text-left">Teléfono</th>
                        <th class="px-4 py-3 text-left">Dirección</th>
                        <th class="px-4 py-3 text-left rounded-tr-lg">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    @if(strtolower($usuario->rol) != 'admin')
                    
                    <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @php
                                $colores = ['bg-blue-500', 'bg-green-500', 'bg-red-500', 'bg-amber-500', 'bg-purple-500', 'bg-pink-500'];
                                $color = $colores[$loop->index % count($colores)];
                                @endphp
                                <div class="w-10 h-10 flex items-center justify-center {{ $color }} text-white font-semibold rounded-full uppercase text-sm flex-shrink-0">
                                    {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-medium text-gray-900 truncate">{{ $usuario->nombre }}</div>
                                    <div class="text-xs text-slate-400 truncate">{{ $usuario->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3 capitalize text-slate-600">
                            <div class="flex items-center gap-1.5">
                                @if(strtolower($usuario->rol) === 'vendedor')
                                <i class='bx bx-store text-amber-500 text-lg'></i>
                                @else
                                <i class='bx bx-user text-slate-400 text-lg'></i>
                                @endif
                                <span>{{ ucfirst($usuario->rol) }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            @if(strtolower($usuario->rol) === 'vendedor')
                                {{ $usuario->nombre_empresa ?? '—' }}
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-slate-600 font-mono-num">{{ $usuario->telefono }}</td>

                        <td class="px-4 py-3 text-slate-600">
                            @if($usuario->calle || $usuario->ciudad || $usuario->codigo_postal || $usuario->pais)
                            {{ $usuario->calle ?? '' }},
                            {{ $usuario->ciudad ?? '' }},
                            {{ $usuario->codigo_postal ?? '' }},
                            {{ $usuario->pais ?? '' }}
                            @else
                            <span class="text-slate-400 italic">No disponible</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="inline-flex items-center space-x-3">

                                {{-- Botón Editar --}}
                                <a href="javascript:void(0)" class="btn-editar text-slate-400 hover:text-indigo-600 transition-colors" data-id="{{ $usuario->id }}">
                                    <i class='bx bx-edit text-lg'></i>
                                </a>

                                {{-- Botón Eliminar --}}
                                <a href="javascript:void(0)"
                                    class="btn-borrar text-slate-400 hover:text-red-600 transition-colors"
                                    data-id="{{ $usuario->id }}"
                                    data-nombre="{{ $usuario->nombre }}"
                                    data-rol="{{ $usuario->rol }}"
                                    data-productos="{{ $usuario->productos->count() }}">

                                    <i class="bx bx-trash text-lg"></i>

                                </a>

                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Vista tarjetas (móvil, por debajo de md) -->
        <div class="md:hidden space-y-3">
            @foreach($usuarios as $usuario)
            @if(strtolower($usuario->rol) != 'admin')
            <div class="bg-white border border-gray-100 rounded-lg p-4">
                <div class="flex items-center justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3 min-w-0">
                        @php
                        $colores = ['bg-blue-500', 'bg-green-500', 'bg-red-500', 'bg-amber-500', 'bg-purple-500', 'bg-pink-500'];
                        $color = $colores[$loop->index % count($colores)];
                        @endphp
                        <div class="w-10 h-10 flex items-center justify-center {{ $color }} text-white font-semibold rounded-full uppercase text-sm flex-shrink-0">
                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="font-medium text-gray-900 truncate">{{ $usuario->nombre }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ $usuario->email }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0">
                        <a href="javascript:void(0)" class="btn-editar text-slate-400 hover:text-indigo-600 transition-colors" data-id="{{ $usuario->id }}">
                            <i class='bx bx-edit text-lg'></i>
                        </a>
                        <a href="javascript:void(0)"
                            class="btn-borrar text-slate-400 hover:text-red-600 transition-colors"
                            data-id="{{ $usuario->id }}"
                            data-nombre="{{ $usuario->nombre }}"
                            data-rol="{{ $usuario->rol }}"
                            data-productos="{{ $usuario->productos->count() }}">
                            <i class="bx bx-trash text-lg"></i>
                        </a>
                    </div>
                </div>

                <div class="ledger-divider pt-3 grid grid-cols-2 gap-y-2 gap-x-3 text-xs">
                    <div>
                        <p class="text-slate-400 uppercase tracking-wide mb-0.5">Rol</p>
                        <p class="text-slate-700 capitalize flex items-center gap-1.5">
                            @if(strtolower($usuario->rol) === 'vendedor')
                            <i class='bx bx-store text-amber-500'></i>
                            @else
                            <i class='bx bx-user text-slate-400'></i>
                            @endif
                            {{ ucfirst($usuario->rol) }}
                        </p>
                    </div>
                    @if(strtolower($usuario->rol) === 'vendedor')
                    <div>
                        <p class="text-slate-400 uppercase tracking-wide mb-0.5">Empresa</p>
                        <p class="text-slate-700">{{ $usuario->nombre_empresa ?? '—' }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-slate-400 uppercase tracking-wide mb-0.5">Teléfono</p>
                        <p class="text-slate-700 font-mono-num">{{ $usuario->telefono ?? '—' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-slate-400 uppercase tracking-wide mb-0.5">Dirección</p>
                        @if($usuario->calle || $usuario->ciudad || $usuario->codigo_postal || $usuario->pais)
                        <p class="text-slate-700">
                            {{ $usuario->calle ?? '' }},
                            {{ $usuario->ciudad ?? '' }},
                            {{ $usuario->codigo_postal ?? '' }},
                            {{ $usuario->pais ?? '' }}
                        </p>
                        @else
                        <p class="text-slate-400 italic">No disponible</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div id="contenedorEditar" style="display:none;"></div>

        <div class="paginationU mt-4 flex justify-center">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>