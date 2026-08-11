<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="{{ $usuario->nombre }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
</div>



<input type="hidden" id="usuario_id" name="usuario_id" value="{{ $usuario->id }}">

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Email</label>
    <input type="email" id="email" name="email" value="{{ $usuario->email }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Rol</label>
    <select id="rol" name="rol" class="w-full border border-gray-300 rounded px-3 py-2">
        <option value="cliente" {{ $usuario->rol === 'cliente' ? 'selected' : '' }}>Cliente</option>
        <option value="vendedor" {{ $usuario->rol === 'vendedor' ? 'selected' : '' }}>Vendedor</option>
        <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Teléfono</label>
    <input type="text" id="telefono" name="telefono" value="{{ $usuario->telefono }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Calle</label>
    <input type="text" id="calle" name="calle" value="{{ $usuario->calle }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Ciudad</label>
    <input type="text" id="ciudad" name="ciudad" value="{{ $usuario->ciudad }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Código Postal</label>
    <input type="text" id="codigo_postal" name="codigo_postal" value="{{ $usuario->codigo_postal }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">País</label>
    <input type="text" id="pais" name="pais" value="{{ $usuario->pais }}" class="w-full border border-gray-300 rounded px-3 py-2">
</div>

<div class="flex justify-end space-x-2">
    <button onclick="actualizarUsuario()" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Guardar cambios</button>
</div>
