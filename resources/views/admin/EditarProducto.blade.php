<h3 class="text-xl font-bold mb-4">Editar Producto</h3>

<input type="hidden" id="producto_id" value="{{ $producto->id }}">

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Nombre</label>
    <input type="text" id="nombre" value="{{ $producto->nombre }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Descripción</label>
    <textarea id="descripcion" class="w-full border border-gray-300 rounded px-3 py-2">{{ $producto->descripcion }}</textarea>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Precio (€)</label>
    <input type="number" id="precio" step="0.01" value="{{ $producto->precio }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Descuento (%)</label>
    <input type="number" id="descuento" step="0.01" value="{{ $producto->descuento ?? 0 }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Stock</label>
    <input type="number" id="stock" value="{{ $producto->stock }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Categoría</label>
    <select id="categoria" class="w-full border border-gray-300 rounded px-3 py-2">
        @foreach($categorias as $categoria)
        <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
            {{ $categoria->nombre }}
        </option>
        @endforeach
    </select>
</div>

<div class="flex justify-end space-x-2">
    <button onclick="actualizarProducto()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Guardar cambios
    </button>
</div>