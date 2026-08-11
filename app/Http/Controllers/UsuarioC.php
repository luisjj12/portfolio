<?php

namespace App\Http\Controllers;
use App\Models\Productos;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;


class UsuarioC extends Controller
{
    /**
     *FUNCION QUE MUESTRA EL PASO DE PONER EL NOMBRE DE LA EMPRESA O EL FORMULARIO DE AÑADIR PRODUCTO SI YA LO TIENES PUESTO
     */
    public function index()
    {
        $usuario = auth()->user();

        if ($usuario->rol === 'cliente' && empty($usuario->nombre_empresa)) {
            return view('usuarios.nombreEmpresa');
        }

        return view('layouts.productos', ['categorias' => Categoria::all()]);
    }

    /**
     *FUNCION QUE GUARDA EL NOMBRE DE LA EMPRESA DEL VENDEDOR
     */
    public function guardarEmpresa(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
        ]);

        auth()->user()->update(['nombre_empresa' => $request->input('nombre_empresa')]);

        return redirect()->route('rutaN');
    }

    /**
     *FUNCION QUE CIERRA LA TIENDA DEL VENDEDOR, BORRA TODOS SUS PRODUCTOS Y LO VUELVE A CONVERTIR EN CLIENTE
     */
    public function cerrarTienda(Request $request)
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'vendedor') {
            abort(403);
        }

        $usuario->productos()->delete();
        $usuario->rol = 'cliente';
        $usuario->nombre_empresa = null;
        $usuario->save();

        return redirect('/')->with('aviso', 'Tu tienda se ha cerrado. Tu cuenta ha vuelto a ser de cliente normal.');
    }

    /**
     *
     */
    public function create()
    {

    }

    /**
     *FUNCION QUE GUARDA UN PRODUCTO NUEVO Y CONVIERTE AL USUARIO EN VENDEDOR
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuarioId' => 'required|exists:users,id',
            'imagen' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0|max:100',
            'capacidad' => 'required|integer|min:0',
            'categoria' => 'required|exists:categorias,id',
        ], [
            'imagen.required' => 'Debes seleccionar una imagen para el producto.',
            'imagen.mimes' => 'Ese formato de imagen no se puede mostrar en la web (por ejemplo, las fotos .heic de iPhone no funcionan en la mayoría de navegadores). Sube el producto en formato JPG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede pesar más de 5MB.',
            'descuento.max' => 'El descuento no puede ser mayor de 100%.',
        ]);

        $user = User::find($request->input('usuarioId'));

        $request->flash();

        $producto = new Productos();

        $path = $request->file('imagen')->store('public');

        $producto->nombre = $request->input('nombre');
        $producto->vendedor_id = $request->input('usuarioId');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->descuento = $request->input('descuento');
        $producto->stock = $request->input('capacidad');
        $producto->categoria_id = $request->input('categoria');
        $producto->imagen =  str_replace('public', 'storage', $path);

        $user->rol = "vendedor";

        $user->save();
        $producto->save();

        return redirect('/usuario/detalle/'.$user->id);



    }

    /**
     *
     */
    public function show(string $id)
    {
        //
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

}