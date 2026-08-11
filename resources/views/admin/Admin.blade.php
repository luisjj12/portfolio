<x-app-layout>
    <style>
        @import url('https://fonts.bunny.net/css?family=space-grotesk:500,600,700|jetbrains-mono:500,600,700&display=swap');
        .font-display { font-family: 'Space Grotesk', ui-sans-serif, system-ui, sans-serif; }
        .font-mono-num { font-family: 'JetBrains Mono', ui-monospace, monospace; font-variant-numeric: tabular-nums; }
        .ledger-index {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 10px;
            letter-spacing: 0.05em;
        }
        .ledger-divider {
            background-image: linear-gradient(to right, #D9C9A3 40%, transparent 0%);
            background-position: bottom;
            background-size: 6px 1px;
            background-repeat: repeat-x;
        }
    </style>
    <div class="min-h-screen flex bg-[#F7F5F0] font-sans text-[#1C2333]" x-data="{ sidebarOpen: false }">

        <!-- Overlay móvil -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>

        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="w-64 bg-[#0F1A2B] text-slate-400 flex flex-col fixed inset-y-0 left-0 z-40 transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:flex-shrink-0">
            <div class="h-20 flex items-center px-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-amber-400 rounded flex items-center justify-center text-[#0F1A2B] font-display font-bold text-sm">
                        M
                    </div>
                    <div class="leading-tight">
                        <span class="block text-white font-display font-semibold text-sm tracking-wide">Core Admin</span>
                        <span class="block text-[11px] text-slate-500">Panel de gestión</span>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 pt-6 space-y-0.5">
                <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-2">Menú principal</p>

                <a href="javascript:void(0)" id="btnStats" @click="sidebarOpen = false" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors border-l-2 border-transparent hover:border-amber-400">
                    <span class="ledger-index text-amber-500/70 group-hover:text-amber-400 transition-colors">01</span>
                    <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM6 20v-1a4 4 0 0 1 8 0v1" />
                    </svg>
                    Dashboard
                </a>

                <a href="javascript:void(0)" id="btnProductos" @click="sidebarOpen = false" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors border-l-2 border-transparent hover:border-amber-400">
                    <span class="ledger-index text-amber-500/70 group-hover:text-amber-400 transition-colors">02</span>
                    <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Catálogo
                </a>

                <a href="javascript:void(0)" class="btn-ver-pedidos group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors border-l-2 border-transparent hover:border-amber-400" @click="sidebarOpen = false">
                    <span class="ledger-index text-amber-500/70 group-hover:text-amber-400 transition-colors">03</span>
                    <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Órdenes
                </a>

                <a href="javascript:void(0)" id="btnUser" @click="sidebarOpen = false" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors border-l-2 border-transparent hover:border-amber-400">
                    <span class="ledger-index text-amber-500/70 group-hover:text-amber-400 transition-colors">04</span>
                    <svg class="w-[18px] h-[18px] text-slate-500 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m12-10a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Staff & Clientes
                </a>
            </nav>

            <div class="p-4">
                <div class="bg-white/5 border border-white/10 p-4 rounded-lg">
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Estado del sistema</p>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></div>
                        <span class="text-xs font-medium text-slate-200">Base de datos activa</span>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-h-screen overflow-hidden w-full lg:w-auto">
            <header class="bg-white border-b border-[#E8E3DA] h-20 flex items-center gap-4 px-4 sm:px-8 sticky top-0 z-10">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 hover:text-slate-900" aria-label="Abrir menú">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-lg font-display font-semibold text-[#1C2333]">Panel general</h1>
                    <p class="text-xs text-slate-400">Resumen global de actividad</p>
                </div>
            </header>

            <div class="p-8 overflow-y-auto">
                <div id="contenedorStats" style="display: block;" class="space-y-8">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg border border-[#E8E3DA] border-l-4 border-l-amber-400">
                            <div class="flex items-center justify-between">
                                <div class="bg-[#0F1A2B] w-10 h-10 rounded-lg flex items-center justify-center text-amber-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-md font-mono-num">+12%</span>
                            </div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mt-5">Clientes</p>
                            <span class="text-3xl font-mono-num font-semibold text-[#1C2333] mt-1 block">{{ $clientes }}</span>
                        </div>

                        <div class="bg-white p-6 rounded-lg border border-[#E8E3DA] border-l-4 border-l-emerald-500">
                            <div class="flex items-center justify-between">
                                <div class="bg-[#0F1A2B] w-10 h-10 rounded-lg flex items-center justify-center text-emerald-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">Global</span>
                            </div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mt-5">Ventas totales</p>
                            <span class="text-3xl font-mono-num font-semibold text-[#1C2333] mt-1 block">{{ $pedidos }}</span>
                        </div>

                        <div class="bg-white p-6 rounded-lg border border-[#E8E3DA] border-l-4 border-l-sky-500">
                            <div class="flex items-center justify-between">
                                <div class="bg-[#0F1A2B] w-10 h-10 rounded-lg flex items-center justify-center text-sky-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">Staff</span>
                            </div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mt-5">Vendedores</p>
                            <span class="text-3xl font-mono-num font-semibold text-[#1C2333] mt-1 block">{{ $vendedores }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <div class="lg:col-span-7 bg-white p-6 rounded-lg border border-[#E8E3DA]">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-sm font-display font-semibold text-[#1C2333]">Rendimiento mensual</h2>
                                <select class="text-xs font-medium border border-[#E8E3DA] bg-[#F7F5F0] rounded-md px-2 py-1.5 text-slate-600 focus:ring-1 focus:ring-amber-400 focus:outline-none">
                                    <option>Últimos 12 meses</option>
                                </select>
                            </div>
                            <div class="h-[300px]">
                                <canvas id="ventasChart"></canvas>
                            </div>
                        </div>

                        <div class="lg:col-span-5 bg-white p-6 rounded-lg border border-[#E8E3DA] overflow-hidden flex flex-col">
                            <h2 class="text-sm font-display font-semibold text-[#1C2333] mb-4">Compras reciente</h2>

                            <div class="space-y-1 flex-1 overflow-y-auto">
                                @foreach($ultimas as $ultima)
                                <div class="flex items-center gap-4 py-3 ledger-divider hover:bg-[#F7F5F0] transition-colors -mx-1 px-1">
                                    <div class="w-11 h-11 rounded-lg bg-[#F7F5F0] p-2 border border-[#E8E3DA] flex-shrink-0">
                                        <img src="/{{ $ultima->productos->imagen }}" class="w-full h-full object-contain mix-blend-multiply">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-[#1C2333] leading-none truncate">{{ $ultima->productos->nombre }}</p>
                                        <p class="text-xs text-slate-400 mt-1.5">{{ $ultima->productos->categoria->nombre }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold font-mono-num text-[#1C2333]">${{ $ultima->productos->precio }}</p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ $ultima->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="javascript:void(0)" class="btn-ver-pedidos block w-full mt-4 py-2.5 border border-[#E8E3DA] text-xs font-semibold text-slate-500 rounded-lg hover:bg-[#F7F5F0] hover:text-amber-600 transition-colors text-center">
                                Ver todo el historial
                            </a>
                        </div>
                    </div>
                </div>

                <div id="contenedorTabla" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500"></div>
                <div id="contenedorUser" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500"></div>
                <div id="contenedorProductos" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500"></div>
                <div id="contenedorDetalle" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-500"></div>

            </div>
        </main>
    </div>

    <!-- MODAL EDITAR USUARIO -->
    <div id="modalEditar" class="fixed inset-0 bg-[#0F1A2B]/60 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative border border-[#E8E3DA]">
            <button id="cerrarModalEditar" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-xl leading-none">&times;</button>
            <div id="contenidoEditar"></div>
        </div>
    </div>

    <!-- MODAL EDITAR PRODUCTO -->
    <div id="modalEditarProducto" class="fixed inset-0 bg-[#0F1A2B]/60 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative border border-[#E8E3DA]">
            <button id="cerrarModalEditarProducto" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-xl leading-none">&times;</button>
            <div id="contenidoEditarProducto"></div>
        </div>
    </div>

    <!-- MODAL ELIMINAR USUARIO -->
    <div id="modalEliminar"
        class="fixed inset-0 bg-[#0F1A2B]/60 hidden items-center justify-center z-50">

        <div class="bg-white rounded-lg p-6 w-[90vw] max-w-md border border-[#E8E3DA]">

            <h2 class="text-xl font-display font-bold mb-4 text-[#1C2333]">
                Eliminar usuario
            </h2>

            <p id="textoModal" class="mb-6 text-gray-600"></p>

            <div class="flex justify-end gap-3">

                <button id="cancelarEliminar"
                    class="px-4 py-2 rounded-lg border border-[#E8E3DA] hover:bg-[#F7F5F0] transition-colors">
                    Cancelar
                </button>

                <button id="confirmarEliminar"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Eliminar
                </button>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //PAGINAS ACTUALIZACION DE PAGINAS Y ESTILOS DE LOS USUARIOS

            // Función para cargar usuarios vía AJAX
            function cargarUsuarios(url = '/usuarios') {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // para que Laravel detecte AJAX
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const contenedor = document.getElementById('contenedorUser');
                        contenedor.innerHTML = html;
                        enlazarPaginacionU(); // re-enlaza eventos a los links después de cargar
                    })
                    .catch(err => console.error('Error cargando usuarios:', err));
            }

            // Función para enlazar eventos a los links de paginación
            function enlazarPaginacionU() {
                const contenedor = document.getElementById('contenedorUser');
                // Selecciona los links dentro del paginador generado, que tiene clase paginationU
                const enlaces = contenedor.querySelectorAll('.paginationU a');
                enlaces.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.href;
                        cargarUsuarios(url);
                    });
                });
            }

            // Event delegation para el botón btnUser
            document.addEventListener('click', function(e) {
                if (e.target && e.target.id === 'btnUser') {
                    e.preventDefault();

                    // Mostrar y ocultar contenedores según tu lógica
                    document.getElementById('contenedorTabla').style.display = 'none';
                    document.getElementById('contenedorUser').style.display = 'block';
                    document.getElementById('contenedorStats').style.display = 'none';
                    document.getElementById('contenedorProductos').style.display = 'none';
                    document.getElementById('contenedorDetalle').style.display = 'none';

                    cargarUsuarios(); // cargar página 1 y enlazar paginación
                }

                if (e.target.closest('.btn-ver-pedidos')) {
                    e.preventDefault();

                    document.getElementById('contenedorUser').style.display = 'none';
                    document.getElementById('contenedorTabla').style.display = 'block';
                    document.getElementById('contenedorStats').style.display = 'none';
                    document.getElementById('contenedorProductos').style.display = 'none';
                    document.getElementById('contenedorDetalle').style.display = 'none';


                    fetch('/pedidos')
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('contenedorTabla').innerHTML = html;
                        });
                }

                if (e.target && e.target.id === 'btnStats') {
                    e.preventDefault();

                    document.getElementById('contenedorUser').style.display = 'none';
                    document.getElementById('contenedorTabla').style.display = 'none';
                    document.getElementById('contenedorStats').style.display = 'block';
                    document.getElementById('contenedorProductos').style.display = 'none';
                    document.getElementById('contenedorDetalle').style.display = 'none';



                }


                //PAGINAS ACTUALIZACION DE PAGINAS Y ESTILOS DE LOS PRODUCTOS 

                function cargarProductos(url = '/productos') {
                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest' // para que Laravel detecte AJAX
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            const contenedor = document.getElementById('contenedorProductos');
                            contenedor.innerHTML = html;
                            enlazarPaginacion();
                        })
                        .catch(err => console.error('Error cargando productos:', err));
                }

                function enlazarPaginacion() {
                    const contenedor = document.getElementById('contenedorProductos');
                    // Cambia el selector según el paginador real, ejemplo para Laravel Tailwind:
                    const enlaces = contenedor.querySelectorAll('nav[role="navigation"] a');
                    enlaces.forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            const url = this.href;
                            cargarProductos(url);
                        });
                    });
                }

                document.addEventListener('click', function(e) {
                    if (e.target && e.target.id === 'btnProductos') {
                        e.preventDefault();
                        document.getElementById('contenedorUser').style.display = 'none';
                        document.getElementById('contenedorTabla').style.display = 'none';
                        document.getElementById('contenedorStats').style.display = 'none';
                        document.getElementById('contenedorProductos').style.display = 'block';
                        document.getElementById('contenedorDetalle').style.display = 'none';

                        cargarProductos(); // carga inicial
                    }
                });

                const contenedorProductos = document.getElementById('contenedorProductos');

                document.getElementById('contenedorTabla').addEventListener('click', (e) => {
                    const btn = e.target.closest('.btnPedidoID');
                    if (btn) {
                        e.preventDefault();
                        const id = btn.dataset.pedidoId;
                        console.log('ID pedido:', id);

                        fetch(`/pedido/${id}`)
                            .then(res => res.text())
                            .then(html => {
                                console.log('Respuesta fetch:', html);
                                document.getElementById('contenedorTabla').style.display = 'none'; // ocultar tabla
                                document.getElementById('contenedorDetalle').style.display = 'block'; // mostrar detalles
                                document.getElementById('contenedorDetalle').innerHTML = html; // Mostrar detalles
                            })
                            .catch(error => {
                                console.error('Error en fetch:', error);
                            });
                    }
                });



            });

            // ----------- Gráfica ventas por mes -----------
            const ventasPHP = @json($ventas);
            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];

            const datosVentas = meses.map((_, i) => ventasPHP[i + 1] ?? 0);

            const ctx = document.getElementById('ventasChart')?.getContext('2d');

            if (ctx) {
                // Crear gradiente vertical para las barras
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(15, 26, 43, 0.9)');
                gradient.addColorStop(1, 'rgba(217, 164, 65, 0.55)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Ventas',
                            data: datosVentas,
                            backgroundColor: gradient,
                            borderWidth: 2,
                            borderRadius: 8,
                            hoverBackgroundColor: 'rgba(217, 164, 65, 0.9)',
                            hoverBorderColor: 'rgba(15, 26, 43, 1)',
                            barPercentage: 0.6,
                            categoryPercentage: 0.7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#1C2333',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 26, 43, 0.95)',
                                titleColor: '#F7F5F0',
                                bodyColor: '#F7F5F0',
                                cornerRadius: 6,
                                padding: 10
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#6B7280',
                                    font: {
                                        size: 13,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#6B7280',
                                    font: {
                                        size: 13,
                                        weight: 'bold'
                                    },
                                    stepSize: 10
                                },
                                grid: {
                                    color: 'rgba(232, 227, 218, 0.8)'
                                }
                            }
                        }
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Delegación: botón editar
            document.addEventListener('click', function(e) {
                const btnEditar = e.target.closest('.btn-editar');
                if (btnEditar) {
                    e.preventDefault();
                    const id = btnEditar.dataset.id;

                    fetch(`/usuarios/editar/${id}`)
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('contenidoEditar').innerHTML = html;
                            document.getElementById('modalEditar').classList.remove('hidden');
                        })
                        .catch(err => console.error('Error al cargar el formulario de edición:', err));
                }
            });

            // Cerrar modal
            document.getElementById('cerrarModalEditar').addEventListener('click', () => {
                document.getElementById('modalEditar').classList.add('hidden');
            });
        });


        document.addEventListener('DOMContentLoaded', () => {

            // ==========================
            // EDITAR
            // ==========================
            document.addEventListener('click', function(e) {

                const btnEditar = e.target.closest('.btn-editar');

                if (!btnEditar) return;

                e.preventDefault();

                const id = btnEditar.dataset.id;

                fetch(`/usuarios/editar/${id}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('contenidoEditar').innerHTML = html;
                        document.getElementById('modalEditar').classList.remove('hidden');
                    })
                    .catch(err => console.error(err));

            });

            document.getElementById('cerrarModalEditar').addEventListener('click', () => {
                document.getElementById('modalEditar').classList.add('hidden');
            });


            // ==========================
            // ELIMINAR
            // ==========================

            const modal = document.getElementById('modalEliminar');
            const textoModal = document.getElementById('textoModal');

            let botonSeleccionado = null;

            // Abrir modal
            document.addEventListener('click', function(e) {

                const boton = e.target.closest('.btn-borrar');

                if (!boton) return;

                e.preventDefault();

                botonSeleccionado = boton;

                const nombre = boton.dataset.nombre;
                const rol = boton.dataset.rol;
                const productos = boton.dataset.productos;

                if (rol === 'vendedor') {

                    textoModal.innerHTML = `
                <strong>${nombre}</strong> tiene
                <strong>${productos}</strong> productos registrados.<br><br>

                Si continúas se eliminarán también todos sus productos.

                <br><br>

                <span class="text-red-600 font-semibold">
                    Esta acción no se puede deshacer.
                </span>
            `;

                } else {

                    textoModal.innerHTML = `
                ¿Seguro que deseas eliminar al usuario
                <strong>${nombre}</strong>?
            `;

                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');

            });

            // Cancelar
            document.getElementById('cancelarEliminar').addEventListener('click', function() {

                modal.classList.add('hidden');
                modal.classList.remove('flex');

            });

            // Confirmar eliminación
            document.getElementById('confirmarEliminar').addEventListener('click', function() {

                const id = botonSeleccionado.dataset.id;
                const token = document.querySelector('meta[name="csrf-token"]').content;

                fetch(`/usuario/borrar/${id}`, {

                        method: 'DELETE',

                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }

                    })
                    .then(async response => {

                        const data = await response.json();

                        if (!response.ok) {
                            console.error(data.message);
                            return;
                        }

                        // Eliminar la fila
                        botonSeleccionado.closest('tr').remove();

                        // Cerrar modal
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');

                    })
                    .catch(error => {

                        console.error(error);

                    });

            });

        });


        function actualizarUsuario() {
            console.log("Entré en actualizarUsuario");
            const id = document.getElementById('usuario_id').value;
            const data = {
                nombre: document.getElementById('nombre').value,
                email: document.getElementById('email').value,
                rol: document.getElementById('rol').value,
                telefono: document.getElementById('telefono').value,
                calle: document.getElementById('calle').value,
                ciudad: document.getElementById('ciudad').value,
                codigo_postal: document.getElementById('codigo_postal').value,
                pais: document.getElementById('pais').value,
            };

            fetch(`/editar/usuario/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error actualizando usuario');
                    return response.json();
                })
                .then(data => {
                    location.reload();
                });
        }







        document.addEventListener('DOMContentLoaded', () => {
            // Delegación: botón editar producto
            document.addEventListener('click', function(e) {
                const btnEditarProducto = e.target.closest('.btn-editar-producto');

                if (btnEditarProducto) {
                    e.preventDefault();
                    const id = btnEditarProducto.dataset.id;

                    fetch(`/producto/editar/${id}`)
                        .then(res => {
                            console.log("Estado:", res.status);
                            return res.text();
                        })
                        .then(html => {
                            console.log(html);

                            document.getElementById('contenidoEditarProducto').innerHTML = html;
                            document.getElementById('modalEditarProducto').classList.remove('hidden');
                        })
                        .catch(err => console.error(err));
                }
            });



            // Cerrar modal
            document.getElementById('cerrarModalEditarProducto').addEventListener('click', () => {
                document.getElementById('modalEditarProducto').classList.add('hidden');
            });
        });


        function actualizarProducto() {
            console.log("Entré en actualizarProducto");

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
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
        }


        document.addEventListener('DOMContentLoaded', () => {

            document.addEventListener('click', function(e) {

                const btnBorrarProducto = e.target.closest('.btn-borrar-producto');

                if (btnBorrarProducto) {
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

                    return;
                }

                const btnBorrarPedido = e.target.closest('#btnBorrar');

                if (btnBorrarPedido) {
                    e.preventDefault();

                    if (!confirm('¿Seguro que deseas eliminar este pedido? Esta acción no se puede deshacer.')) {
                        return;
                    }

                    const id = btnBorrarPedido.dataset.orderId;
                    const token = document.querySelector('meta[name="csrf-token"]').content;

                    fetch(`/borrar/${id}`, {

                            method: 'DELETE',

                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest'
                            }

                        })
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('contenedorTabla').innerHTML = html;
                            document.getElementById('contenedorDetalle').style.display = 'none';
                            document.getElementById('contenedorTabla').style.display = 'block';
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }

            });

            // Cambio de estado de un pedido (pendiente/enviado/entregado/cancelado)
            document.addEventListener('change', function(e) {

                const selectEstado = e.target.closest('#selectEstadoPedido');

                if (!selectEstado) return;

                const pedidoId = selectEstado.dataset.pedidoId;
                const nuevoEstado = selectEstado.value;
                const token = document.querySelector('meta[name="csrf-token"]').content;

                fetch(`/pedido/estado/${pedidoId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ estado: nuevoEstado }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al actualizar el estado del pedido');
                        }

                        const coloresEstado = {
                            pendiente: 'bg-amber-100 text-amber-700',
                            enviado: 'bg-sky-100 text-sky-700',
                            entregado: 'bg-emerald-100 text-emerald-700',
                            cancelado: 'bg-slate-100 text-slate-600',
                        };
                        const baseClases = 'text-xs font-semibold px-3 py-1 pr-6 rounded-full border-0 cursor-pointer focus:ring-2 focus:ring-indigo-400';
                        selectEstado.className = `${baseClases} ${coloresEstado[nuevoEstado]}`;
                    })
                    .catch(error => {
                        console.error(error);
                        alert('No se pudo actualizar el estado del pedido.');
                    });
            });

        });
    </script>

</x-app-layout>