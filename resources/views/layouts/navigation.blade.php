@if(Auth::check() && Auth::user()->rol == "cliente")
<style>
    @import url('https://fonts.bunny.net/css?family=space-grotesk:500,600,700|jetbrains-mono:500,600&display=swap');
    .font-display { font-family: 'Space Grotesk', ui-sans-serif, system-ui, sans-serif; }
    .font-mono-num { font-family: 'JetBrains Mono', ui-monospace, monospace; font-variant-numeric: tabular-nums; }
</style>
<nav class="bg-gray-900 text-white fixed top-0 left-0 w-full z-50 shadow-md">
    @elseif(Auth::check() && Auth::user()->rol == "vendedor")
    <nav class="bg-emerald-600 text-white fixed top-0 left-0 w-full z-50 shadow-md">
        @elseif(Auth::check() && Auth::user()->rol == "admin")
        <nav class="bg-violet-600 text-white fixed top-0 left-0 w-full z-50 shadow-md">
            @else
            <nav class="bg-gray-900 text-white fixed top-0 left-0 w-full z-50 shadow-md">
                @endif

                <div class="max-w-7xl mx-auto px-4 md:px-6" x-data="{ mobileMenu: false, userMenu: false }">
                    <div class="flex items-center justify-between h-16">
                        <!-- Logo -->
                        <a href="/" class="flex items-center space-x-2 hover:opacity-80 transition-opacity duration-200 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5V21h6v-5h6v5h6V10.5L12 3z" />
                            </svg>
                            <span class="font-semibold text-xl select-none">MiTienda</span>
                        </a>

                        <!-- Buscador: visible solo desde md hacia arriba -->
                        <form action="/search" method="GET" class="hidden md:flex flex-1 max-w-2xl mx-8 relative" autocomplete="off">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0a7 7 0 11-9.9-9.9 7 7 0 019.9 9.9z" />
                            </svg>
                            <input
                                type="text"
                                name="buscador"
                                id="buscadorDesktop"
                                placeholder="Buscar productos..."
                                value="{{ old('buscador') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-orange-400 transition" />
                            <div id="sugerenciasDesktop" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden z-50 text-gray-900"></div>
                        </form>

                        <!-- Menú derecho: visible solo desde md hacia arriba -->
                        <div class="hidden md:flex items-center space-x-8">
                            @if (Auth::check())
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2 text-white hover:text-gray-400">
                                    <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold uppercase flex-shrink-0">
                                        {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                                    </span>
                                    <span>{{ Auth::user()->nombre }}</span>
                                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-200">
                                        Perfil
                                    </a>

                                    @if(Auth::user()->rol === 'cliente')
                                    <a href="/pedidos_historial" class="block px-4 py-2 text-sm hover:bg-gray-200">
                                        Historial de pedidos
                                    </a>
                                    <a href="/rutaN" class="block px-4 py-2 text-sm hover:bg-gray-200">
                                        Únete a Nosotros
                                    </a>
                                    @endif

                                    @if(Auth::user()->rol === 'vendedor')
                                    <a href="/usuario/detalle/{{ Auth::user()->id }}" class="block px-4 py-2 text-sm hover:bg-gray-200">
                                        Mis Productos
                                    </a>
                                    <a href="/rutaN" class="block px-4 py-2 text-sm hover:bg-gray-200">
                                        Nuevo Producto
                                    </a>
                                    @endif

                                    @if(Auth::user()->rol === 'admin')
                                    <a href="/admin" class="block px-4 py-2 text-sm hover:bg-gray-200">
                                        Panel de administración
                                    </a>
                                    @endif

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-200 text-gray-700">Cerrar sesión</button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('login') }}" class="text-white hover:text-gray-400">Iniciar sesión</a>
                            @endif

                            @if(Auth::check() && Auth::user()->rol != 'admin')
                            <a href="/pedidos_historial" class="text-white hover:text-gray-400">Tus pedidos</a>
                            <a href="/favoritos" class="text-white hover:text-gray-400">Favoritos</a>
                            <a href="/carrito" id="btnCarrito" class="btnCarrito flex items-center text-white hover:text-gray-400 space-x-2 relative cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h15l-1.5 9H8.25M6 6l-.75-3H2m4.5 3L7.5 15m0 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm9 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                                </svg>
                                <span>Cesta</span>
                            </a>
                            @endif
                        </div>

                        <!-- Botones móvil: carrito directo + hamburguesa -->
                        <div class="flex items-center gap-3 md:hidden">
                            @if(Auth::check() && Auth::user()->rol != 'admin')
                            <a href="/carrito" id="btnCarritoMobile" class="btnCarrito text-white relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h15l-1.5 9H8.25M6 6l-.75-3H2m4.5 3L7.5 15m0 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm9 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                                </svg>
                            </a>
                            @endif
                            @unless(Auth::check())
                            <a href="{{ route('login') }}" class="bg-white text-gray-900 text-xs font-bold uppercase tracking-wide px-3.5 py-2 rounded-full">
                                Entrar
                            </a>
                            @endunless
                            <button @click="mobileMenu = !mobileMenu" class="text-white" aria-label="Abrir menú">
                                <svg x-show="!mobileMenu" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg x-show="mobileMenu" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Panel móvil desplegable -->
                    <div x-show="mobileMenu" x-cloak @click.away="mobileMenu = false" class="md:hidden pb-4 space-y-3" style="display:none">

                        <!-- Buscador móvil -->
                        <form action="/search" method="GET" class="relative" autocomplete="off">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0a7 7 0 11-9.9-9.9 7 7 0 019.9 9.9z" />
                            </svg>
                            <input
                                type="text"
                                name="buscador"
                                id="buscadorMovil"
                                placeholder="Buscar productos..."
                                value="{{ old('buscador') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-orange-400 transition" />
                            <div id="sugerenciasMovil" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden z-50 text-gray-900"></div>
                        </form>

                        <div class="border-t border-white/20 pt-3 space-y-1">
                            @if (Auth::check())
                            <p class="px-2 flex items-center gap-2 text-sm text-gray-300">
                                <span class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold uppercase text-white flex-shrink-0">
                                    {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                                </span>
                                {{ Auth::user()->nombre }}
                            </p>
                            <a href="{{ route('profile.edit') }}" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Perfil</a>

                            @if(Auth::user()->rol != 'admin')
                            <a href="/favoritos" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Favoritos</a>
                            @endif

                            @if(Auth::user()->rol === 'cliente')
                            <a href="/pedidos_historial" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Historial de pedidos</a>
                            <a href="/rutaN" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Únete a Nosotros</a>
                            @endif

                            @if(Auth::user()->rol === 'vendedor')
                            <a href="/usuario/detalle/{{ Auth::user()->id }}" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Mis Productos</a>
                            <a href="/rutaN" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Nuevo Producto</a>
                            @endif

                            @if(Auth::user()->rol === 'admin')
                            <a href="/admin" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Panel de administración</a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Cerrar sesión</button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="block px-2 py-2 text-sm text-white hover:bg-white/10 rounded">Iniciar sesión</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal del carrito -->
                <div id="modalCarrito" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-end items-start z-50 hidden">
                    <div class="bg-white w-full sm:w-96 h-full overflow-y-auto shadow-2xl relative flex flex-col">

                        <div class="p-6 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
                            <h2 class="text-lg font-display font-semibold text-gray-900">Tu carrito</h2>
                            <button id="cerrarModal" class="w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-900 transition-colors text-xl leading-none">&times;</button>
                        </div>

                        <div id="detalleCarrito" class="flex-1 p-6 space-y-1 divide-y divide-gray-100">
                        </div>

                        <div class="p-6 bg-slate-50 border-t border-gray-100 space-y-5 flex-shrink-0">
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span id="cantidadCarrito" class="font-medium text-gray-500"></span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="text-sm font-semibold text-gray-900">Total</span>
                                    <span id="totalCarrito" class="text-2xl font-display font-bold font-mono-num text-indigo-600"></span>
                                </div>
                            </div>

                            <a href="/pagar" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3.5 rounded-xl transition-all shadow-lg shadow-indigo-100 text-sm flex items-center justify-center gap-2 group active:scale-[0.98]">
                                Proceder al pago
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>

                            <p class="text-center text-[11px] font-medium text-gray-400 flex items-center justify-center gap-1.5">
                                <i class='bx bx-lock-alt'></i> Pago seguro procesado por PayPal
                            </p>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="h-16"></div>

            <script>
                // Función compartida para pintar el carrito, reutilizada también por productoDetalle.blade.php.
                window.pintarItemsCarrito = function(items, config) {
                    const { container, totalEl, cantidadEl, renderRow, emptyHtml, formatTotal, formatCantidad } = config;

                    container.innerHTML = '';

                    if (!items.length) {
                        if (emptyHtml) container.innerHTML = emptyHtml;
                        if (totalEl) totalEl.textContent = '';
                        if (cantidadEl) cantidadEl.textContent = '';
                        return;
                    }

                    let total = 0;
                    let cantidadTotal = 0;

                    items.forEach(function(item) {
                        const precioNum = Number(item.producto.precio);
                        const subtotal = (isNaN(precioNum) ? 0 : precioNum) * item.cantidad;

                        total += subtotal;
                        cantidadTotal += item.cantidad;

                        container.insertAdjacentHTML('beforeend', renderRow(item, item.producto, subtotal));
                    });

                    if (totalEl) totalEl.textContent = formatTotal ? formatTotal(total) : total.toFixed(2);
                    if (cantidadEl) cantidadEl.textContent = formatCantidad ? formatCantidad(cantidadTotal) : cantidadTotal;
                };

                // Desplaza un carrusel de tarjetas (inicio.blade.php, productoDetalle.blade.php) un elemento a la vez.
                window.nextSlide = function(id) {
                    const carousel = document.getElementById(id);
                    const item = carousel?.querySelector(':scope > *');
                    if (!item) return;
                    const gap = 24; // gap-6 = 1.5rem = 24px
                    const itemWidth = item.getBoundingClientRect().width + gap;
                    carousel.scrollBy({ left: itemWidth, behavior: 'smooth' });
                };

                window.prevSlide = function(id) {
                    const carousel = document.getElementById(id);
                    const item = carousel?.querySelector(':scope > *');
                    if (!item) return;
                    const gap = 24;
                    const itemWidth = item.getBoundingClientRect().width + gap;
                    carousel.scrollBy({ left: -itemWidth, behavior: 'smooth' });
                };

                // Añadir/quitar un producto de favoritos desde cualquier tarjeta de producto.
                window.toggleFavorito = function(btn) {
                    const token = document.querySelector('meta[name="csrf-token"]').content;

                    fetch(`/producto/favorito/${btn.dataset.productoId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        })
                        .then(res => res.json())
                        .then(data => {
                            const svg = btn.querySelector('svg');
                            if (data.favorito) {
                                svg.classList.remove('text-gray-400');
                                svg.classList.add('text-red-500');
                                svg.setAttribute('fill', 'currentColor');
                            } else {
                                svg.classList.remove('text-red-500');
                                svg.classList.add('text-gray-400');
                                svg.setAttribute('fill', 'none');
                            }
                        });
                };

                document.addEventListener('DOMContentLoaded', function() {
                    const botonesCarrito = document.querySelectorAll('.btnCarrito');
                    const modalCarrito = document.getElementById('modalCarrito');
                    const detalleCarrito = document.getElementById('detalleCarrito');
                    const cerrarModal = document.getElementById('cerrarModal');
                    const totalCarrito = document.getElementById('totalCarrito');
                    const cantidadCarrito = document.getElementById('cantidadCarrito');

                    // Función para mostrar carrito
                    function mostrarCarrito() {
                        fetch('/carrito')
                            .then(res => {
                                if (!res.ok) throw new Error('Error en la respuesta: ' + res.status);
                                return res.json();
                            })
                            .then(data => {
                                window.pintarItemsCarrito(data.itemsPedido || [], {
                                    container: detalleCarrito,
                                    totalEl: totalCarrito,
                                    cantidadEl: cantidadCarrito,
                                    formatTotal: t => `${t.toFixed(2)}€`,
                                    formatCantidad: c => `${c} unidad${c == 1 ? '' : 'es'}`,
                                    emptyHtml: `
                                        <div class="h-full flex flex-col items-center justify-center text-center py-12">
                                            <div class="w-14 h-14 bg-indigo-50 rounded-full flex items-center justify-center mb-3">
                                                <i class='bx bx-cart text-2xl text-indigo-400'></i>
                                            </div>
                                            <p class="text-sm font-medium text-gray-500">Tu carrito está vacío</p>
                                        </div>
                                    `,
                                    renderRow: (item, producto, subtotal) => {
                                        const precioFormateado = (Number(producto.precio) || 0).toFixed(2);
                                        return `
                            <div class="py-4 first:pt-0 flex items-center gap-4">
                                <div class="w-16 h-16 flex-shrink-0 bg-slate-50 rounded-xl p-2 border border-gray-100">
                                    <img src="${producto.imagen}" alt="${producto.nombre}" class="w-full h-full object-contain mix-blend-multiply">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-display font-semibold text-gray-900 leading-tight truncate">${producto.nombre}</h3>
                                    <p class="text-xs text-gray-400 truncate mt-0.5">${producto.descripcion}</p>

                                    <div class="flex items-center gap-2 mt-1.5">
                                        <p class="text-sm font-bold font-mono-num text-indigo-600">${precioFormateado}€</p>
                                        <p class="text-[11px] font-semibold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded font-mono-num">x${item.cantidad}</p>
                                    </div>
                                </div>

                                <button class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors btn-eliminar" data-id="${item.producto_id}">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        `;
                                    },
                                });
                            })
                    }

                    window.mostrarCarrito = mostrarCarrito;

                    // Quitar un producto del carrito (delegado, las filas se pintan dinámicamente)
                    document.addEventListener('click', function(e) {
                        const btnEliminar = e.target.closest('.btn-eliminar');
                        if (!btnEliminar) return;

                        const token = document.querySelector('meta[name="csrf-token"]').content;

                        fetch(`/producto/carro/${btnEliminar.dataset.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (detalleCarrito.contains(btnEliminar)) {
                                    mostrarCarrito();
                                    return;
                                }
                                if (typeof window.mostrarCarritoProducto === 'function' && document.getElementById('pintarCarrito')?.contains(btnEliminar)) {
                                    window.mostrarCarritoProducto(data.itemsPedido || []);
                                    return;
                                }
                                // Página de pago (u otra vista que no tenga su propio modal): recargamos
                                // para recalcular el total completo con los productos que quedan.
                                location.reload();
                            });
                    });

                    botonesCarrito.forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            mostrarCarrito();
                            modalCarrito.classList.remove('hidden');
                        });
                    });

                    // Cerrar modal
                    cerrarModal.addEventListener('click', () => {
                        modalCarrito.classList.add('hidden');
                    });

                    // Cerrar modal haciendo clic fuera del contenido
                    modalCarrito.addEventListener('click', (e) => {
                        if (e.target === modalCarrito) {
                            modalCarrito.classList.add('hidden');
                        }
                    });

                    // Escapa texto antes de meterlo en el HTML, para que un nombre de
                    // producto con < > " ' no pueda ejecutar código en la página.
                    function escaparHtml(texto) {
                        const div = document.createElement('div');
                        div.textContent = texto ?? '';
                        return div.innerHTML;
                    }

                    // Autocompletado del buscador (escritorio y móvil)
                    function configurarAutocompletado(inputId, dropdownId) {
                        const input = document.getElementById(inputId);
                        const dropdown = document.getElementById(dropdownId);
                        if (!input || !dropdown) return;

                        let temporizador = null;

                        input.addEventListener('input', () => {
                            clearTimeout(temporizador);
                            const q = input.value.trim();

                            if (q.length < 2) {
                                dropdown.classList.add('hidden');
                                dropdown.innerHTML = '';
                                return;
                            }

                            temporizador = setTimeout(() => {
                                fetch(`/search/autocompletar?q=${encodeURIComponent(q)}`)
                                    .then(res => res.json())
                                    .then(productos => {
                                        if (!productos.length) {
                                            dropdown.classList.add('hidden');
                                            dropdown.innerHTML = '';
                                            return;
                                        }

                                        dropdown.innerHTML = productos.map(p => `
                                            <a href="/producto/detalle/${p.id}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                                <img src="${p.imagen}" class="w-9 h-9 object-contain bg-gray-50 rounded-md flex-shrink-0">
                                                <span class="text-sm font-medium flex-1 truncate">${escaparHtml(p.nombre)}</span>
                                            </a>
                                        `).join('');
                                        dropdown.classList.remove('hidden');
                                    });
                            }, 250);
                        });

                        // Cerrar el desplegable al hacer clic fuera
                        document.addEventListener('click', (e) => {
                            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                                dropdown.classList.add('hidden');
                            }
                        });
                    }

                    configurarAutocompletado('buscadorDesktop', 'sugerenciasDesktop');
                    configurarAutocompletado('buscadorMovil', 'sugerenciasMovil');

                });
            </script>