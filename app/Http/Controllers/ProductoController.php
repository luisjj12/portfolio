<?php

namespace App\Http\Controllers;

use App\Models\Carrito_compras;
use App\Models\Favorito;
use App\Models\Productos;
use App\Models\Categoria;
use App\Models\Comentarios;
use App\Models\Items_pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     *FUNCION QUE MUESTRA LA PAGINA DE INICIO CON LOS PRODUCTOS DESTACADOS, MAS COMPRADOS, NUEVOS, EN OFERTA Y LOS DE LA CATEGORIA HOGAR
     */
    public function index()
    {
        $productos = $this->productosConValoracion(Productos::query());

        $categoriaHogar = Categoria::where('nombre', 'like', '%hogar%')->first();

        if ($categoriaHogar) {
            $productosH = $this->productosConValoracion(Productos::where('categoria_id', $categoriaHogar->id));
        } else {
            $productosH = collect();
        }

        $nuevosProductos = $this->productosConValoracion(Productos::orderBy('created_at', 'desc')->take(4));
        $productoOferta = $this->productosConValoracion(Productos::orderBy('descuento', 'desc')->take(4));

        $productosPorRating = $productos->sortByDesc('valoracion_promedio')->take(4);
        $productoPorOpiniones = $productos->sortByDesc('total_valoraciones')->take(4);
        $productosCarrusel = $productos->sortByDesc('valoracion_promedio');

        return view('inicio.inicio', [
            'ratingD' => $productosPorRating,
            'opiniones' => $productoPorOpiniones,
            'productosC' => $productosCarrusel,
            'productosR' => $nuevosProductos,
            'productosO' => $productoOferta,
            'productosH' => $productosH
        ]);
    }

    /**
     *FUNCION QUE CALCULA LA VALORACION MEDIA Y SI ES FAVORITO DE CADA PRODUCTO DE LA CONSULTA QUE LE PASES
     */
    private function productosConValoracion($query)
    {
        $idsFavoritos = $this->idsFavoritos();

        return $query->with('comentarios')->get()->map(function ($producto) use ($idsFavoritos) {
            $producto->valoracion_promedio = $producto->comentarios->avg('rating') ?? 0;
            $producto->total_valoraciones = $producto->comentarios->count();
            $producto->es_favorito = $idsFavoritos->contains($producto->id);
            return $producto;
        });
    }

    /**
     *FUNCION QUE DEVUELVE LOS IDS DE LOS PRODUCTOS FAVORITOS DEL USUARIO QUE HA INICIADO SESION
     */
    private function idsFavoritos()
    {
        if (!auth()->check()) {
            return collect();
        }

        return Favorito::where('usuario_id', auth()->id())->pluck('producto_id');
    }



    /**
     *FUNCION QUE BUSCA PRODUCTOS POR EL NOMBRE QUE ESCRIBES EN EL BUSCADOR
     */
    public function search(Request $request)
    {
        $palabra = $request->input('buscador');

        $buscar = Productos::where('nombre', 'like', '%' . $palabra . '%')->get();

        $filtradoS = Productos::where('nombre', 'like', '%' . $palabra . '%')->distinct()->pluck('categoria_id');

        $comentarios = comentarios::all();
        $idsFavoritos = $this->idsFavoritos();

        foreach ($buscar as $producto) {
            $calificacionesProducto = $comentarios->where('producto_id', $producto->id);
            $producto->valoracion_promedio = $calificacionesProducto->avg('rating');

            $producto->total_valoraciones = $calificacionesProducto->count();
            $producto->es_favorito = $idsFavoritos->contains($producto->id);
        }


        return view('productos.cardBusqueda', ['detalles' => $buscar, 'filtros' => $filtradoS, 'categorias' => Categoria::all(), 'palabra' => $palabra]);
    }

    /**
     *FUNCION QUE DEVUELVE LAS SUGERENCIAS QUE SALEN MIENTRAS ESCRIBES EN EL BUSCADOR
     */
    public function autocompletar(Request $request)
    {
        $palabra = trim((string) $request->input('q', ''));

        if (mb_strlen($palabra) < 2) {
            return response()->json([]);
        }

        $productos = Productos::where('nombre', 'like', '%' . $palabra . '%')
            ->take(6)
            ->get(['id', 'nombre', 'imagen']);

        return response()->json($productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'imagen' => '/' . ltrim($producto->imagen, '/'),
            ];
        }));
    }

    /**
     *FUNCION QUE FILTRA LOS PRODUCTOS POR CATEGORIA, PRECIO Y VALORACION MINIMA
     */
    public function busqueda(Request $request)
    {
        $palabra = $request->input('palabra');
        $categoria = $request->input('categoria');
        $rating = $request->input('rating');
        $precioMin = $request->input('min');
        $precioMaxInput = $request->input('max');

        if ($precioMin === null || $precioMin === '') {
            $precioMin = 0;
        }

        $idsFavoritos = $this->idsFavoritos();

        $buscar = Productos::with('comentarios')
            ->where('nombre', 'like', '%' . $palabra . '%')
            ->when($categoria, fn($query) => $query->where('categoria_id', $categoria))
            ->where('precio', '>=', $precioMin)
            ->when(
                $precioMaxInput !== null && $precioMaxInput !== '',
                fn($query) => $query->where('precio', '<=', $precioMaxInput)
            )
            ->get()
            ->filter(function ($producto) use ($rating, $idsFavoritos) {
                $promedio = $producto->comentarios->avg('rating');
                $producto->valoracion_promedio = $promedio;
                $producto->total_valoraciones = $producto->comentarios->count();
                $producto->es_favorito = $idsFavoritos->contains($producto->id);

                if (!$rating) return true;

                return $promedio >= $rating;
            });

        return view('productos.cardFiltroC', [
            'detalles' => $buscar,
            'categorias' => Categoria::all(),
            'precioMax' => $precioMaxInput,
            'palabra' => $palabra,
        ]);
    }

    /**
     *
     */
    public function create() {}


    /**
     *FUNCION QUE SE EJECUTA CUANDO SE COMPLETA EL PAGO DE PAYPAL, GUARDA EL PEDIDO, QUITA EL STOCK Y VACIA EL CARRITO
     */
    public function pagoTerminar(Request $request)
    {
        $productos = $request->input('id');
        $usuario = auth()->id();

        try {
            DB::transaction(function () use ($productos, $usuario, $request) {
                foreach ($productos as $producto) {
                    // lockForUpdate bloquea la fila del producto hasta que termine esta
                    // transacción, para que dos compras a la vez no vendan más stock del que hay.
                    $productoDb = Productos::where('id', $producto['id'])->lockForUpdate()->firstOrFail();
                    $cantidad = (int) $producto['cantidad'];

                    if ($cantidad > $productoDb->stock) {
                        throw new \RuntimeException("No hay suficiente stock de \"{$productoDb->nombre}\". Disponible: {$productoDb->stock}.");
                    }

                    $pedido = new Items_pedido();
                    $pedido->pedido_id = $request->input('paypal_order_id');
                    $pedido->producto_id = $productoDb->id;
                    $pedido->usuario_id = $usuario;
                    $pedido->cantidad = $cantidad;
                    $pedido->precio = $productoDb->precio * $cantidad;
                    $pedido->pago = 'pagado';

                    $pedido->save();

                    $productoDb->stock = max(0, $productoDb->stock - $cantidad);
                    $productoDb->save();
                }

                Carrito_compras::where('usuario_id', $usuario)->delete();
            });

            return response()->json(['mensaje' => 'Pago recibido correctamente']);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Error al guardar el pedido: ' . $e->getMessage());
            return response()->json(['error' => 'Error al guardar el pedido'], 500);
        }
    }




    /**
     *
     */
    public function store(Request $request) {}

    /**
     *FUNCION QUE MUESTRA EL DETALLE DE UN PRODUCTO CON SUS COMENTARIOS Y PRODUCTOS RELACIONADOS
     */
    public function show(Productos $productos)
    {
        $productos->load('categoria');
        $comentarios = $productos->comentarios()->get();
        $estrella = $comentarios->avg('rating') ?? 0;
        $usuario = User::all();

        $relacionados = $this->productosConValoracion(
            Productos::where('categoria_id', $productos->categoria_id)
                ->where('id', '!=', $productos->id)
                ->take(10)
        );

        $precioSimilar = $this->productosConValoracion(
            Productos::where('id', '!=', $productos->id)
                ->whereBetween('precio', [$productos->precio * 0.7, $productos->precio * 1.3])
                ->orderByRaw('ABS(precio - ?) asc', [$productos->precio])
                ->take(10)
        );

        return view('productos.productoDetalle', [
            'detalles' => $productos,
            'totales' => $productos->stock,
            'media' => $estrella,
            'comentarios' => $comentarios,
            'usuarios' => $usuario,
            'relacionados' => $relacionados,
            'precioSimilar' => $precioSimilar,
        ]);
    }


    /**
     *FUNCION QUE MUESTRA LA PAGINA DE PAGO CON EL RESUMEN DEL CARRITO
     */
    public function pagar()
    {
        $resumen = $this->cargarResumenCarrito();

        if ($resumen['cantidades']->isEmpty()) {
            return redirect('/busqueda')->with('aviso', 'Tu carrito está vacío. Añade algún producto antes de pagar.');
        }

        return view('usuarios.sistemaPagos', $resumen);
    }

    /**
     *FUNCION QUE MUESTRA LA PAGINA DE GRACIAS POR TU COMPRA CON PRODUCTOS RECOMENDADOS
     */
    public function pagoCompleto()
    {
        return view('usuarios.pagoCompleto', [
            'productos' => $this->productosConValoracion(Productos::query())->sortByDesc('valoracion_promedio')->take(10),
        ]);
    }

    /**
     *FUNCION QUE CARGA EL CARRITO DEL USUARIO CON LOS TOTALES YA CALCULADOS
     */
    private function cargarResumenCarrito()
    {
        $carritos = Carrito_compras::where('usuario_id', auth()->id())->get();

        $producto = Productos::whereIn('id', $carritos->pluck('producto_id'))->get();

        $totalPrecio = 0;
        $totalCantidad = 0;

        foreach ($carritos as $carrito) {
            $productoLinea = Productos::find($carrito->producto_id);

            $totalPrecio += $carrito->cantidad * $productoLinea->precio;
            $totalCantidad += $carrito->cantidad;
        }

        return ['productos' => $producto, 'cantidades' => $carritos, 'totales' => $totalPrecio, 'totalCantidad' => $totalCantidad];
    }

    /**
     *FUNCION QUE MUESTRA EL FORMULARIO PARA DEJAR UN COMENTARIO EN UN PRODUCTO
     */
    public function comentario(Productos $productos)
    {

        return view('productos.comentario', ['productos' => $productos]);
    }

    /**
     *FUNCION QUE AÑADE UN PRODUCTO AL CARRITO O SUMA LA CANTIDAD SI YA ESTABA
     */
    public function carrito(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $usuarioId = auth()->id();
        $producto = Productos::findOrFail($request->producto_id);

        $existe = Carrito_compras::where('usuario_id', $usuarioId)->where('producto_id', $request->producto_id)->first();
        $cantidadEnCarrito = $existe->cantidad ?? 0;

        if ($cantidadEnCarrito + $request->cantidad > $producto->stock) {
            return response()->json([
                'error' => 'No hay suficiente stock disponible.',
                'stock_disponible' => $producto->stock,
            ], 422);
        }

        if ($existe) {
            $existe->cantidad += $request->cantidad;
            $existe->save();
        } else {
            $carrito = new Carrito_compras();
            $carrito->usuario_id = $usuarioId;
            $carrito->producto_id = $request->producto_id;
            $carrito->cantidad = $request->cantidad;

            $carrito->save();
        }

        return response()->json([
            'itemsPedido' => $this->cargarItemsCarrito($usuarioId),
        ]);
    }

    /**
     *FUNCION QUE QUITA UN PRODUCTO DEL CARRITO DEL USUARIO
     */
    public function quitarDelCarrito(Productos $producto)
    {
        $usuarioId = auth()->id();

        Carrito_compras::where('usuario_id', $usuarioId)
            ->where('producto_id', $producto->id)
            ->delete();

        return response()->json([
            'itemsPedido' => $this->cargarItemsCarrito($usuarioId),
        ]);
    }

    /**
     *FUNCION QUE DEVUELVE LOS PRODUCTOS DEL CARRITO DE UN USUARIO
     */
    private function cargarItemsCarrito($usuarioId)
    {
        return Carrito_compras::with('producto')
            ->where('usuario_id', $usuarioId)
            ->get()
            ->map(function ($item) {
                $item->producto->imagen = '/' . ltrim($item->producto->imagen, '/');
                return $item;
            });
    }


    /**
     *FUNCION QUE GUARDA EL COMENTARIO Y LA VALORACION QUE DEJA UN USUARIO EN UN PRODUCTO
     */
    public function comentarioUsuario(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'comentario' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $usuario = auth()->id();

        $productoId = $request->input('producto_id');

        $request->flash();
        $comentario = new Comentarios();
        $comentario->comentario = $request->input('comentario');
        $comentario->usuario_id = $usuario;
        $comentario->producto_id = $request->input('producto_id');
        $comentario->rating = $request->input('rating');

        $comentario->save();


        return redirect('/producto/detalle/' . $productoId);
    }





    /**
     *
     */
    public function edit(string $id)
    {
        //
    }

    /**
     *
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     *
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     *FUNCION QUE CAMBIA LA CANTIDAD DE UN PRODUCTO QUE YA ESTA EN EL CARRITO
     */
    public function sumar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Productos::findOrFail($request->input('producto_id'));

        if ($request->input('cantidad') > $producto->stock) {
            return response()->json([
                'error' => 'No hay suficiente stock disponible.',
                'stock_disponible' => $producto->stock,
            ], 422);
        }

        $carroSuma = Carrito_compras::where('usuario_id', auth()->id())
            ->where('producto_id', $request->input('producto_id'))
            ->firstOrFail();

        $carroSuma->cantidad = $request->input('cantidad');
        $carroSuma->save();

        return response()->json(['stock_disponible' => $producto->stock]);
    }


    /**
     *FUNCION QUE DEVUELVE EL CARRITO PARA PINTARLO EN EL MENU DE ARRIBA
     */
    public function cestaNav()
    {
        return response()->json([
            'itemsPedido' => $this->cargarItemsCarrito(auth()->id()),
        ]);
    }

    /**
     *FUNCION QUE MUESTRA EL HISTORIAL DE PEDIDOS DEL USUARIO AGRUPADOS POR PEDIDO
     */
    public function historialPedido()
    {
        $pedidos = Items_pedido::where('usuario_id', auth()->id())
            ->with('productos')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('pedido_id');

        return view('productos.historialPedidos', ['pedidos' => $pedidos]);
    }

    /**
     *FUNCION QUE AÑADE O QUITA UN PRODUCTO DE FAVORITOS
     */
    public function toggleFavorito(Productos $producto)
    {
        $usuarioId = auth()->id();

        $favorito = Favorito::where('usuario_id', $usuarioId)->where('producto_id', $producto->id)->first();

        if ($favorito) {
            $favorito->delete();
            $esFavorito = false;
        } else {
            Favorito::create(['usuario_id' => $usuarioId, 'producto_id' => $producto->id]);
            $esFavorito = true;
        }

        return response()->json(['favorito' => $esFavorito]);
    }

    /**
     *FUNCION QUE MUESTRA LA LISTA DE PRODUCTOS FAVORITOS DEL USUARIO
     */
    public function misFavoritos()
    {
        $idsFavoritos = Favorito::where('usuario_id', auth()->id())->pluck('producto_id');

        $productos = $this->productosConValoracion(Productos::whereIn('id', $idsFavoritos));

        return view('productos.favoritos', ['productos' => $productos]);
    }
}
