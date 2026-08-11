<x-app-layout>
    <div class="bg-gray-100 min-h-screen pt-24">
        <div class="container mx-auto mt-8">
            <h1 class="text-3xl font-bold text-gray-800">{{ $productos->nombre }}</h1>
            
            <!-- Detalles del producto -->
            <div class="mt-6 bg-white shadow-sm p-6 rounded-lg">
                <p class="text-gray-700"><strong>Descripción:</strong> {{ $productos->descripcion }}</p>
                <p class="text-gray-700 mt-2"><strong>Precio:</strong> ${{ $productos->precio }}</p>
                <img src="/{{ $productos->imagen }}" alt="Product image" class="h-[200px] object-contain rounded-md">
            </div>

            <!-- Formulario para añadir un comentario -->
            @if(auth()->check())
                <div class="mt-10">
                    <h2 class="text-xl font-bold">Añadir un comentario</h2>
                    <!-- Formulario para enviar calificación y comentario -->
                    <form action="/comentario/usuario" method="POST" class="mt-4">
                        @csrf

                        <!-- Calificación interactiva con estrellas -->
                        <div class="mb-4">
                            <label for="rating" class="block text-gray-700 font-bold mb-2">Calificación:</label>
                            <div id="star-rating" class="flex items-center space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button 
                                        type="button" 
                                        class="star text-gray-400 text-2xl hover:text-yellow-500 transition focus:outline-none" 
                                        data-value="{{ $i }}">
                                        ★
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating" value="5">
                            <input type="hidden" name="producto_id" id="producto_id" value="{{$productos->id}}">
                        </div>

                        <!-- Comentario -->
                        <textarea 
                            name="comentario" rows="4" class="w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                            placeholder="Escribe tu comentario aquí..." 
                            required></textarea>
                        <button type="submit" class="mt-3 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            Publicar
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-10">
                    <p class="text-gray-600">Por favor, <a href="{{ route('login') }}" class="text-blue-500 hover:underline">inicia sesión</a> para añadir un comentario.</p>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = this.dataset.value;
                    ratingInput.value = rating;

                    // Resaltar estrellas seleccionadas
                    stars.forEach(s => {
                        s.classList.remove('text-yellow-500');
                        s.classList.add('text-gray-400');
                    });
                    for (let i = 0; i < rating; i++) {
                        stars[i].classList.remove('text-gray-400');
                        stars[i].classList.add('text-yellow-500');
                    }
                });
            });
        });
    </script>
</x-app-layout>
