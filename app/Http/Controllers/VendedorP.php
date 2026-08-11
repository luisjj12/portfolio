<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Items_pedido;
use App\Models\Productos;
use App\Models\User;

class VendedorP extends Controller
{
    /**
     *FUNCION QUE MUESTRA TODOS LOS PRODUCTOS SI ERES ADMIN O SOLO LOS TUYOS SI ERES VENDEDOR
     */
    public function index()
    {
        $users = auth()->user()->id;
        $user = User::find($users);


        if(auth()->user()->rol == "admin"){
            return view('admin.AdminVendedor', ['productos' => Productos::with('vendedor')->paginate(7), 'categorias' => Categoria::all()]);
        }else{
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

}
