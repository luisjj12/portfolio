<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categoria;
use App\Models\Items_pedido;
use App\Models\User;
use Illuminate\Http\Request;

class AdminControl extends Controller
{
    /**
     *FUNCION QUE  MUESTRA EL PANEL DEL ADMINISTRADOR CON TODOS LOS USUARIOS Y PRODUCTOS QUE TIENE LA PAGINA
     *TAMBIEN MUESTRA EN UNA GRAFICA LAS COMPRAS HECHAS POR MES Y LISTA LOS ULTIMOS PRODUCTOS COMPRADOS
     */
    public function index()
    {
        $totalU = User::where('rol', 'cliente')->count();
        $totalP = Items_pedido::all()->count();
        $totalV = User::where('rol', 'vendedor')->count();

        $ventasPorMes = Items_pedido::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $ventaM = [];
        for ($i = 1; $i <= 12; $i++) {
            $ventaM[$i] = $ventasPorMes[$i] ?? 0;
        }

        $ultimasV = Items_pedido::with('productos.categoria')->orderBy('created_at', 'desc')->take(6)->get();


        return view('admin.Admin', ['clientes' => $totalU, 'pedidos' => $totalP, 'vendedores' => $totalV, 'ventas' => $ventaM, 'ultimas' => $ultimasV]);
    }

    /**
     *FUNCION QUE MUESTRA LA LISTA DE TODOS LOS PRODUCTOS PAGINADAS CON 5 PRODUCTOS POR PAGINA
     */
    public function productos()
    {
        $productos = Productos::with('vendedor')->paginate(5);
        $categorias = Categoria::all();
        return view('admin.Productos', ['productos' => $productos, 'categorias' => $categorias]);
    }


    /**
     *FUNCION PARA PODER PODER LISTAR TODOS LOS PEDIDOS Y QUE NO SE REPITEN 
     */
    public function pedidos()
    {
        $pedidos = Items_pedido::with('usuarios')->get()->unique('pedido_id');

        return view('admin.Pedidos', ['pedidos' => $pedidos]);
    }


    /**
     *FUNCION QUE DETALLA UN PEDIDO REALIZADO
     */
    public function pedidoID($pedido_id)
    {
        $pedidos = Items_pedido::where('pedido_id', $pedido_id)->with('productos')->get();
        $usuario = Items_pedido::where('pedido_id', $pedido_id)->with('usuarios')->first();


        $fr = Items_pedido::where('pedido_id', $pedido_id)->first();
        $total = Items_pedido::where('pedido_id', $pedido_id)->count();

        $subtotal = Items_pedido::where('pedido_id', $pedido_id)->sum('precio');

        $totalDescuento = $pedidos->sum(function ($pedido) {
            $descuento = $pedido->productos->descuento ?? 0;
            $precio = $pedido->productos->precio;
            return $precio * ($descuento / 100);
        });


        $totaD = $subtotal - $totalDescuento;





        return view('admin.PedidosID', [
            'pedidos' => $pedidos,
            'orden' => $pedido_id,
            'pago' => $fr,
            'usuarios' => $usuario,
            'total' => $total,
            'subTotal' => $subtotal,
            'descuento' => $totaD,
            'sumaD' => $totalDescuento
        ]);
    }


    /**
     *FUNCION QUE MUESTRA LA LISTA DE TODOS LOS USUARIOS PAGINADAS CON 5 PRODUCTOS POR PAGINA
     */
    public function usuarios()
    {
        $usuarios = User::paginate(5);

        return view('admin.Usuarios', ['usuarios' => $usuarios]);
    }

    /**
     *FUNCION QUE MUESTRA TODOS LOS PRODUCTOS DE LA TIENDA CON UNA CONDICION DE QUE SI ERES ADMIN PUEDES VER TODOS LOS PRODUCTOS DE LA PAGINA PERO SI ERES VENDEDOR SOLO PUEDES VER TUS PRODUCTOS
     */
    public function show(User $user)
    {
        $users = auth()->user()->id;
        $user = User::find($users);


        if (auth()->user()->rol == "admin") {
            return view('admin.AdminVendedor', ['productos' => Productos::with('vendedor')->paginate(7), 'categorias' => Categoria::all()]);
        } else {
            $idsProductos = $user->productos()->pluck('id');

            $totalVentas = Items_pedido::whereIn('producto_id', $idsProductos)->sum('precio');
            $totalPedidosVendedor = Items_pedido::whereIn('producto_id', $idsProductos)->count();

            $ventasPorMes = Items_pedido::whereIn('producto_id', $idsProductos)
                ->selectRaw('MONTH(created_at) as mes, SUM(precio) as total')
                ->groupBy('mes')
                ->pluck('total', 'mes')
                ->toArray();

            $ventaM = [];
            for ($i = 1; $i <= 12; $i++) {
                $ventaM[$i] = $ventasPorMes[$i] ?? 0;
            }

            return view('admin.AdminVendedor', [
                "productos" => $user->productos()->paginate(7),
                "countP" => $user->productos()->count(),
                "categorias" => Categoria::all(),
                "totalVentas" => $totalVentas,
                "totalPedidosVendedor" => $totalPedidosVendedor,
                "ventasPorMes" => $ventaM,
            ]);
        }
    }

    /**
     *
     */
    public function edit(string $id)
    {
        //
    }

    /**
     *FUNCION QUE USAR EL ADMIN PARA PODER ACTUALIZAR UN PRODUCTO DESDE EL PANEL DEL ADMINISTRADOR
     */
    public function update(Request $request, Productos $producto)
    {
        $request->validate([
            'usuarioId' => 'required|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required|exists:categorias,id',
        ]);

        $producto->vendedor_id = $request->input('usuarioId');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->descuento = $request->input('descuento');
        $producto->stock = $request->input('stock');
        $producto->categoria_id = $request->input('categoria');

        $producto->save();

        return redirect()->back();
    }

    /**
     *FUNCION PARA BORRA UN USUARIO SI ERA UN VENDEDOR BORRA TAMBIEN SUS PRODUCTOS Y LO CONVIERTE EN CLIENTE
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->rol === 'vendedor') {
            $user->productos()->delete();
        }

        $user->delete();

        return response()->json();
    }


    /**
     *FUNCION PARA BORRA UN PEDIDO 
     */
    public function borrar($id)
    {
        Items_pedido::where('pedido_id', $id)->delete();

        $pedidos = Items_pedido::with('usuarios')->get()->unique('pedido_id');
        return view('admin.Pedidos', ['pedidos' => $pedidos]);
    }

    /**
     *FUNCION PARA PODER ACTUALIZAR EL ESTADO DEL PEDIDO 
     */
    public function actualizarEstadoPedido(Request $request, $pedido_id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,enviado,entregado,cancelado',
        ]);

        Items_pedido::where('pedido_id', $pedido_id)->update(['estado' => $request->input('estado')]);

        return response()->json(['mensaje' => 'Estado actualizado']);
    }


    /**
     *FUNCION PARA PODER EDITAR LOS DATOS DE UN USUARIO
     */
    public function usuarioEdit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.Editar', ['usuario' => $usuario]);
    }


    /**
     *FUNCION PARA ACTUALIZAR UN USUARIO
     */
    public function editarUsuario(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'rol' => 'required|in:cliente,vendedor,admin',
            'telefono' => 'nullable|string|max:20',
            'calle' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'pais' => 'nullable|string|max:100',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->rol = $request->input('rol');
        $usuario->telefono = $request->input('telefono');
        $usuario->calle = $request->input('calle');
        $usuario->ciudad = $request->input('ciudad');
        $usuario->codigo_postal = $request->input('codigo_postal');
        $usuario->pais = $request->input('pais');

        $usuario->save();

        if ($request->ajax()) {
            return response()->json(['mensaje' => 'Usuario actualizado'], 200);
        }

        return back()->with('success', 'Usuario actualizado');
    }

    /**
     *FUNCION PARA PODER ACTUALIZAR UN PRODUCTO
     */
    public function productoEdit($id)
    {
        $producto = Productos::findOrFail($id);
        $categoria = Categoria::all();
        return view('admin.EditarProducto', ['producto' => $producto, 'categorias' => $categoria]);
    }


    /**
     *FUNCION QUE ACTULIZA UN PRODUCTO
     */
    public function editProducto(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $producto = Productos::findOrFail($id);
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->descuento = $request->input('descuento');
        $producto->stock = $request->input('stock');
        $producto->categoria_id = $request->input('categoria_id');

        $producto->save();

        return response()->json(['mensaje' => 'Usuario actualizado'], 200);
    }


    /**
     *FUNCION QUE BORRA UN PRODUCTO ADEMAS SI EL PRODUCTO BORRADO ES EL ULTIMO EL VENDEDOR DEJA DE SER UN VENDEDOR Y PASA A SER UN CLIENTE
     */
    public function borrarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $vendedorId = $producto->vendedor_id;

        $producto->delete();

        $vendedor = User::find($vendedorId);
        if ($vendedor && $vendedor->rol === 'vendedor' && Productos::where('vendedor_id', $vendedorId)->count() === 0) {
            $vendedor->rol = 'cliente';
            $vendedor->save();
        }

        return response()->noContent();
    }
}
