<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Gestión de Inventario</h2>
                @if(auth()->user()->rol === 'vendedor')
                    <p class="text-sm text-gray-500">
                        <span class="font-semibold text-gray-700">{{ auth()->user()->nombre_empresa }}</span>
                        — administra tus productos, precios y existencias en tiempo real.
                    </p>
                @else
                    <p class="text-sm text-gray-500">Administra los productos, precios y existencias de todos los vendedores.</p>
                @endif
            </div>
            <div class="flex items-center gap-4">
                @if(auth()->user()->rol === 'vendedor')
                    <form method="POST" action="/vendedor/tienda" onsubmit="return confirm('¿Seguro que quieres cerrar tu tienda? Se eliminarán tus {{ $countP }} producto(s) y tu cuenta volverá a ser de cliente normal. Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center bg-white hover:bg-red-50 text-red-600 hover:text-gray-900 font-bold py-2.5 px-6 rounded-xl border-2 border-red-200 hover:border-red-400 shadow-sm transition-all transform hover:-translate-y-0.5">
                            <i class='bx bx-store-alt mr-2 text-xl'></i> Cerrar tienda
                        </button>
                    </form>
                @endif
                <a href="/rutaN" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                    <i class='bx bx-plus-circle mr-2 text-xl'></i> Nuevo Producto
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg text-blue-600 mr-4"><i class='bx bx-box text-2xl'></i></div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Productos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $countP }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg text-green-600 mr-4"><i class='bx bx-check-shield text-2xl'></i></div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Estado Sistema</p>
                        <p class="text-2xl font-bold text-gray-900 text-green-600">Activo</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-orange-100 rounded-lg text-orange-600 mr-4"><i class='bx bx-Package text-2xl'></i></div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Categorías</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($categorias) }}</p>
                    </div>
                </div>
            </div>


            <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
                <table class="w-full min-w-[800px] text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Producto</th>
                            @if(auth()->user()->rol === 'admin')
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Empresa</th>
                            @endif
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Precio / Dto</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($productos as $value)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="/{{ $value->imagen }}" class="h-12 w-12 rounded-lg object-cover ring-2 ring-gray-100">
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $value->nombre }}</div>
                                        <div class="text-xs text-gray-400">ID: #{{ $value->id }}</div>
                                    </div>
                                </div>
                            </td>
                            @if(auth()->user()->rol === 'admin')
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $value->vendedor->nombre_empresa ?? $value->vendedor->nombre ?? '—' }}
                                </td>
                            @endif
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium bg-indigo-50 text-indigo-600 rounded-full">
                                    {{ $value->categoria->nombre ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($value->descuento > 0)
                                    <div class="text-sm font-bold text-gray-900">€{{ number_format($value->precio * (1 - $value->descuento / 100), 2) }}</div>
                                    <div class="text-xs text-gray-400 line-through">€{{ number_format($value->precio, 2) }}</div>
                                    <div class="text-xs text-red-500 font-medium">-{{ number_format($value->descuento, 0) }}% dto.</div>
                                @else
                                    <div class="text-sm font-bold text-gray-900">€{{ number_format($value->precio, 2) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $value->stock }} unidades
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="javascript:void(0)" class="btn-editar-producto" data-id="{{ $value->id }}">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn-borrar-producto"
                                        data-id="{{ $value->id }}"
                                        data-nombre="{{ $value->nombre }}">
                                        <i class='bx bx-trash text-red-500 hover:text-red-700 text-lg'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-3">
                @foreach($productos as $value)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                    <div class="flex items-start gap-3 mb-3">
                        <img src="/{{ $value->imagen }}" class="h-14 w-14 rounded-lg object-cover ring-2 ring-gray-100 flex-shrink-0">
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-bold text-gray-900 truncate">{{ $value->nombre }}</div>
                            <div class="text-xs text-gray-400">ID: #{{ $value->id }}</div>
                            @if(auth()->user()->rol === 'admin')
                                <div class="text-xs text-gray-500 mt-0.5">{{ $value->vendedor->nombre_empresa ?? $value->vendedor->nombre ?? '—' }}</div>
                            @endif
                            <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-medium bg-indigo-50 text-indigo-600 rounded-full">
                                {{ $value->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <a href="javascript:void(0)" class="btn-editar-producto" data-id="{{ $value->id }}">
                                <i class='bx bx-edit text-lg'></i>
                            </a>
                            <a href="javascript:void(0)"
                                class="btn-borrar-producto"
                                data-id="{{ $value->id }}"
                                data-nombre="{{ $value->nombre }}">
                                <i class='bx bx-trash text-red-500 hover:text-red-700 text-lg'></i>
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs">
                        @if($value->descuento > 0)
                            <span class="text-sm font-bold text-gray-900">€{{ number_format($value->precio * (1 - $value->descuento / 100), 2) }}</span>
                            <span class="text-gray-400 line-through">€{{ number_format($value->precio, 2) }}</span>
                            <span class="text-red-500 font-medium">-{{ number_format($value->descuento, 0) }}% dto.</span>
                        @else
                            <span class="text-sm font-bold text-gray-900">€{{ number_format($value->precio, 2) }}</span>
                        @endif
                        <span class="text-gray-600">{{ $value->stock }} unidades</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $productos->links() }}
            </div>

        </div>
    </div>

    <!-- MODAL EDITAR PRODUCTO -->
    <div id="modalEditarProducto" class="fixed inset-0 bg-gray-900/60 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative border border-gray-200">
            <button id="cerrarModalEditarProducto" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl leading-none">&times;</button>
            <div id="contenidoEditarProducto"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.addEventListener('click', function(e) {

                const btnBorrarProducto = e.target.closest('.btn-borrar-producto');

                if (!btnBorrarProducto) return;

                e.preventDefault();
                

                const id = btnBorrarProducto.dataset.id;
                const token = document.querySelector('meta[name="csrf-token"]').content;

                fetch(`/producto/borrar/${id}`, {

                        method: 'DELETE',

                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }

                    })
                    .then(response => {

                        if (!response.ok) {
                            throw new Error('Error al eliminar el producto');
                        }

                        // Eliminar la fila de la tabla
                        btnBorrarProducto.closest('tr').remove();

                    })
                    .catch(error => {
                        console.error(error);
                    });

            });

            // Abrir modal de edición de producto
            document.addEventListener('click', function(e) {
                const btnEditarProducto = e.target.closest('.btn-editar-producto');
                if (!btnEditarProducto) return;

                e.preventDefault();
                const id = btnEditarProducto.dataset.id;

                fetch(`/producto/editar/${id}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('contenidoEditarProducto').innerHTML = html;
                        document.getElementById('modalEditarProducto').classList.remove('hidden');
                    })
                    .catch(err => console.error(err));
            });

            document.getElementById('cerrarModalEditarProducto').addEventListener('click', () => {
                document.getElementById('modalEditarProducto').classList.add('hidden');
            });

        });

        function actualizarProducto() {
            const id = document.getElementById('producto_id').value;

            const data = {
                nombre: document.getElementById('nombre').value,
                descripcion: document.getElementById('descripcion').value,
                precio: document.getElementById('precio').value,
                descuento: document.getElementById('descuento').value,
                stock: document.getElementById('stock').value,
                categoria_id: document.getElementById('categoria').value,
            };

            fetch(`/editar/producto/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error actualizando producto');
                    return response.json();
                })
                .then(() => {
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
</x-app-layout>