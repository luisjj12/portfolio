@section('title', 'Tu carrito — MiTienda')

<x-app-layout>
    <div class="bg-slate-50 min-h-screen pb-20">
        <div class="bg-white border-b border-gray-200 mb-10 pt-16">
            <div class="max-w-7xl mx-auto px-4 py-8">
                <nav class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">
                    <a href="/" class="hover:text-gray-900 transition-colors">Inicio</a>
                    <span class="mx-1.5">/</span>
                    <span class="text-gray-900">Carrito</span>
                </nav>
                <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                    <i class='bx bx-shopping-bag text-orange-500'></i>
                    Cesta de Compras
                </h1>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                        {{-- MANTENEMOS TU LÓGICA DE FILTRADO EXACTA --}}
                        @foreach($productos as $producto)
                        @foreach($cantidades as $cantidad)
                        @if($producto->id == $cantidad->producto_id)

                        <div class="flex flex-col sm:flex-row items-center mb-8 border-b border-gray-100 pb-6 last:border-0 last:mb-0">
                            <img src="/{{ $producto->imagen }}" alt="Product image" class="h-32 w-32 object-contain rounded-xl bg-gray-50 p-2 mb-4 sm:mb-0 sm:mr-6 border border-gray-100">

                            <div class="flex-1 text-center sm:text-left mt-4 sm:mt-0">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">{{$producto->nombre}}</h4>

                                <div class="space-y-1">
                                    <p class="text-sm text-gray-500">
                                        Cantidad: <span class="cantidad-text font-bold text-gray-700" data-id="{{$producto->id}}">{{$cantidad->cantidad}}</span>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Precio unitario: €<span class="precio font-bold text-gray-700" data-id="{{$producto->id}}">{{$producto->precio}}</span>
                                    </p>
                                    <p class="text-md font-semibold text-indigo-600">
                                        Subtotal: €<span class="subtotal" data-id="{{$producto->id}}">{{$producto->precio * $cantidad->cantidad}}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 mt-4 sm:mt-0">
                                <div class="flex items-center space-x-3 bg-gray-50 p-2 rounded-full border border-gray-200">
                                    <button class="restar bg-white hover:bg-gray-100 text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-sm transition-all font-bold" data-id="{{ $producto->id }}">-</button>

                                    <input type="number" class="cantidad w-12 text-center bg-transparent border-none focus:ring-0 font-bold text-gray-800" value="{{ $cantidad->cantidad }}" data-id="{{ $producto->id }}" min="1" readonly>

                                    <button class="sumar bg-white hover:bg-gray-100 text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-sm transition-all font-bold" data-id="{{ $producto->id }}">+</button>
                                </div>

                                <button class="btn-eliminar w-10 h-10 flex items-center justify-center rounded-full text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors" data-id="{{ $producto->id }}" title="Quitar del carrito">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>

                        @endif
                        @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 sticky top-24">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8 border-b pb-4">Resumen</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium text-lg">Cantidad total:</span>
                                <span id="totalPedidos" class="font-bold text-gray-900 text-xl">{{$totalCantidad}}</span>
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                                <span class="text-gray-900 font-bold text-xl">Total:</span>
                                <div class="text-right">
                                    <span class="text-3xl font-black text-indigo-600">€<span id="totalCarro">{{ number_format($totales, 2) }}</span></span>
                                </div>
                            </div>

                            <div class="mt-10">
                                <div id="paypal-button-container" class="z-10 relative"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="cargar" class="hidden fixed inset-0 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm z-[100]">
        <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center">
            <div class="animate-spin rounded-full h-10 w-10 border-4 border-indigo-500 border-t-transparent"></div>
            <p class="mt-3 font-bold text-gray-600">Actualizando...</p>
        </div>
    </div>
</x-app-layout>

<script src="https://www.paypal.com/sdk/js?client-id=AVfiZSif_KwPqWWwVrtltRBRUzof2keYHR82dzHeG5m6kNUNqaRJV7Zj4cyb-azF5pkuVNujaxvIMmOo&currency=EUR"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    paypal.Buttons({

        style: {
            label: 'pay',
        },
        createOrder: function(data, actions) {

            const total = document.getElementById('totalCarro').textContent;
            console.log("Total como número:", total);
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: total
                    }
                }]
            });
        },

        onApprove: function(data, actions) {
            actions.order.capture().then(function(details) {
                // Cuando PayPal confirma el pago exitoso...

                const total = document.getElementById('totalCarro').textContent;
                const cantidad = document.getElementById('totalPedidos').textContent;


                const datos = [];
                document.querySelectorAll('.cantidad').forEach(input => {
                    datos.push({
                        id: input.dataset.id,
                        cantidad: parseInt(input.value, 10)
                    });
                });


                fetch('/sistema-pagos', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            total: total,
                            cantidad: cantidad,
                            paypal_order_id: data.orderID,
                            id: datos,
                        })
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, data })))
                    .then(({ ok, data }) => {
                        if (!ok) {
                            alert(data.error || 'Hubo un error al registrar el pago. Intenta nuevamente.');
                            return;
                        }
                        window.location.href = '/pago-completo';
                    })
                    .catch(error => {
                        console.error('Error al enviar los datos al servidor:', error);
                        alert('Hubo un error al registrar el pago. Intenta nuevamente.');
                    });
            });
        }
    }).render('#paypal-button-container');


    document.querySelectorAll(".sumar").forEach(boton => {
        boton.addEventListener('click', () => {
            const productoId = boton.getAttribute('data-id');
            const cantidadInput = document.querySelector(`.cantidad[data-id='${productoId}']`);
            const cantidadAnterior = parseInt(cantidadInput.value);
            let cantidad = cantidadAnterior + 1;
            cantidadInput.value = cantidad;
            document.querySelector(`.cantidad-text[data-id='${productoId}']`).textContent = cantidad;
            mostrarCargando();
            actualizarCantidadEnServidor(productoId, cantidad).then(({
                ok,
                data
            }) => {
                if (!ok) {
                    cantidadInput.value = cantidadAnterior;
                    document.querySelector(`.cantidad-text[data-id='${productoId}']`).textContent = cantidadAnterior;
                    alert(data.error || 'No hay suficiente stock disponible.');
                }
            }).finally(() => {
                ocultarCargando();
                actualizarTotalCarro();
                actualizarTotalPedido();
            });
        });
    });



    document.querySelectorAll(".restar").forEach(boton => {
        boton.addEventListener('click', () => {
            const productoId = boton.getAttribute('data-id');
            const cantidadInput = document.querySelector(`.cantidad[data-id='${productoId}']`);
            let cantidad = parseInt(cantidadInput.value);
            if (cantidad > 1) {
                cantidad--;
                cantidadInput.value = cantidad;
                document.querySelector(`.cantidad-text[data-id='${productoId}']`).textContent = cantidad;
                mostrarCargando();
                actualizarCantidadEnServidor(productoId, cantidad).finally(() => {
                    ocultarCargando();
                    actualizarTotalCarro();
                    actualizarTotalPedido();
                });
            }
        });
    });






    function mostrarCargando() {
        document.getElementById('cargar').classList.remove('hidden');
    }


    function ocultarCargando() {
        document.getElementById('cargar').classList.add('hidden');
    }


    function actualizarCantidadEnServidor(productoId, cantidad) {
        return fetch('/sumarCarro', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    producto_id: productoId,
                    cantidad: cantidad
                })
            })
            .then(response => response.json().then(data => ({ ok: response.ok, data })));
    }


    function actualizarTotalCarro() {
        let total = 0;
        document.querySelectorAll('.cantidad').forEach(input => {
            const productoId = input.getAttribute('data-id');
            const cantidad = parseInt(input.value);
            const precio = parseFloat(document.querySelector(`.precio[data-id='${productoId}']`).textContent);
            const subtotal = cantidad * precio;
            document.querySelector(`.subtotal[data-id='${productoId}']`).textContent = subtotal.toFixed(2);
            total += subtotal;
        });
        document.getElementById('totalCarro').textContent = total.toFixed(2);
    }

    function actualizarTotalPedido() {

        let totales = 0;
        document.querySelectorAll('.cantidad').forEach(input => {
            const cantidad = parseInt(input.value);
            totales += cantidad;
        })
        document.getElementById('totalPedidos').textContent = totales.toFixed(0);

    }
</script>