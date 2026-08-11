<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-8">

                    <div class="mb-6 border-b border-gray-200 pb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Nuevo Producto</h3>
                        <p class="text-sm text-gray-500 mt-1">Completa la información para añadir un producto al catálogo</p>
                    </div>

                    @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-md p-4 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="/usuarioProducto" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                            <div class="sm:col-span-2">
                                <label for="nombre" class="block font-medium text-sm text-gray-700 mb-1">Nombre</label>
                                <input class="block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="descripcion" class="block font-medium text-sm text-gray-700 mb-1">Descripción</label>
                                <input class="block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" id="descripcion" name="descripcion" type="text" value="{{ old('descripcion') }}" required>
                            </div>

                            <div>
                                <label for="capacidad" class="block font-medium text-sm text-gray-700 mb-1">Capacidad</label>
                                <input class="block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" id="capacidad" name="capacidad" type="text" value="{{ old('capacidad') }}" required>
                            </div>

                            <div>
                                <label for="precio" class="block font-medium text-sm text-gray-700 mb-1">Precio</label>
                                <input class="block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" id="precio" name="precio" type="text" value="{{ old('precio') }}" required>
                            </div>

                            <div>
                                <label for="descuento" class="block font-medium text-sm text-gray-700 mb-1">Descuento (%)</label>
                                <input class="block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" id="descuento" name="descuento" type="number" min="0" max="100" step="0.01" value="{{ old('descuento', 0) }}">
                                <p class="text-xs text-gray-400 mt-1">Déjalo en 0 si el producto no tiene descuento.</p>
                            </div>

                            <div>
                                <label for="categoria" class="block font-medium text-sm text-gray-700 mb-1">Categoría</label>
                                <select name="categoria" id="categoria" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="imagen" class="block font-medium text-sm text-gray-700 mb-1">Imagen</label>
                                <input class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md shadow-sm cursor-pointer focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-gray-100 file:text-gray-700 file:text-sm file:font-medium hover:file:bg-gray-200" id="imagen" name="imagen" type="file" accept="image/jpeg,image/png,image/webp" required>
                                <p class="text-xs text-gray-400 mt-1">Formatos admitidos: JPG, PNG o WEBP (máx. 5MB). Las fotos .heic de iPhone no se pueden mostrar en la web.</p>
                            </div>

                        </div>

                        <input type="hidden" name="usuarioId" id="usuarioId" value="{{ Auth::User()->id }}">

                        <div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-md shadow-sm transition">
                                Añadir Producto
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>