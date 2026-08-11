<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-8">

                    <div class="mb-6 border-b border-gray-200 pb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Antes de empezar</h3>
                        <p class="text-sm text-gray-500 mt-1">¿Cómo quieres que se llame tu tienda? Este nombre es el que verán los clientes en tus productos.</p>
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

                    <form method="POST" action="/usuarioEmpresa">
                        @csrf

                        <label for="nombre_empresa" class="block font-medium text-sm text-gray-700 mb-1">Nombre de la empresa/tienda</label>
                        <input class="block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" id="nombre_empresa" name="nombre_empresa" type="text" value="{{ old('nombre_empresa') }}" placeholder="Ej: Muebles García" required autofocus>

                        <div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-md shadow-sm transition">
                                Continuar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
