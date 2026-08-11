<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
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
            return view('admin.AdminVendedor', ['productos' => Productos::paginate(7), 'categorias' => Categoria::all()]);
        }else{
            return view('admin.AdminVendedor',["productos" => $user->productos()->paginate(7), "countP" => $user->productos()->count() ,  "categorias" => Categoria::all()]) ;
        }

    }

}
