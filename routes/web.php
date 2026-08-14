<?php

use App\Http\Controllers\AdminControl;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioC;
use App\Http\Controllers\VendedorP;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductoController::class, 'index']);

//RUTA DE LOS DETALLES DE LOS PRODUCTOS (pública, no requiere login)
Route::get('/producto/detalle/{productos}' , [ProductoController::class, 'show']);

//PÁGINAS DE INFORMACIÓN DEL FOOTER (públicas, no requieren login)
Route::view('/contacto', 'paginas.contacto');
Route::view('/preguntas-frecuentes', 'paginas.preguntas-frecuentes');
Route::view('/politica-envios', 'paginas.politica-envios');
Route::view('/devoluciones', 'paginas.devoluciones');
Route::view('/terminos', 'paginas.terminos');
Route::view('/aviso-legal', 'paginas.aviso-legal');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/rutaN', [UsuarioC::class, 'index'])->name('rutaN');
    Route::post('/usuarioProducto', [UsuarioC::class, 'store']);
    Route::post('/usuarioEmpresa', [UsuarioC::class, 'guardarEmpresa']);
    Route::delete('/vendedor/tienda', [UsuarioC::class, 'cerrarTienda']);

    //RUTA COMENTARIO
    Route::get('/comentario/{productos}' , [ProductoController::class, 'comentario']);
    Route::post('/comentario/usuario' , [ProductoController::class, 'comentarioUsuario']);

    //RUTA DEL CARRITO
    Route::post('/producto/carro' , [ProductoController::class, 'carrito']);
    Route::delete('/producto/carro/{producto}' , [ProductoController::class, 'quitarDelCarrito']);
    Route::get('/pagar' , [ProductoController::class, 'pagar']);
    Route::get('/pago-completo' , [ProductoController::class, 'pagoCompleto']);
    Route::post('/sumarCarro' , [ProductoController::class, 'sumar']);
    Route::post('/sistema-pagos', [ProductoController::class, 'pagoTerminar']);

    //DETALLE CESTA
    Route::get('/carrito', [ProductoController::class, 'cestaNav']);

    //Historial de pedidos
    Route::get('/pedidos_historial' , [ProductoController::class, 'historialPedido']);

    //Favoritos
    Route::post('/producto/favorito/{producto}', [ProductoController::class, 'toggleFavorito']);
    Route::get('/favoritos', [ProductoController::class, 'misFavoritos']);

});

Route::middleware(['auth', 'rol:vendedor'])->group(function () {
    //Rutas para la gestion del creador
    Route::get('/vendedor', [VendedorP::class, 'index']); 
    Route::get('/usuario/detalle/{user}', [AdminControl::class, 'show']);

    //Ruta para editar un producto
    Route::get('/producto/editar/{id}' , [AdminControl::class, 'productoEdit']);
    Route::put('/editar/producto/{id}' , [AdminControl::class, 'editProducto']);
        Route::delete('/producto/borrar/{id}' , [AdminControl::class, 'borrarProducto']);

});


Route::middleware(['auth', 'rol:admin'])->group(function () {
    //Rutas para la gestion del creador
    Route::get('/productos', [AdminControl::class, 'productos']);
    Route::get('/pedidos', [AdminControl::class, 'pedidos']);
    Route::get('/usuarios', [AdminControl::class, 'usuarios']);

    Route::get('/pedido/{id}' , [AdminControl::class, 'pedidoID']);
    Route::put('/pedido/estado/{id}', [AdminControl::class, 'actualizarEstadoPedido']);


    Route::get('/usuarios/editar/{id}', [AdminControl::class, 'usuarioEdit']);
    Route::put('/editar/usuario/{id}', [AdminControl::class, 'editarUsuario']);

    Route::delete('/usuario/borrar/{id}', [AdminControl::class, 'destroy']);
    Route::post('/usuario/update/{id}', [AdminControl::class, 'editarUsuario']);
    Route::get('/admin', [AdminControl::class, 'index']);
    Route::post('/producto/update/{producto}' , [AdminControl::class, 'update']);
    Route::delete('/borrar/{id}' , [AdminControl::class, 'borrar']);
    

});


Route::get('/search', [ProductoController::class, 'search']);
Route::get('/search/autocompletar', [ProductoController::class, 'autocompletar']);

//FILTRO BUSQUEDA (público, no requiere login)
Route::get('/busqueda', [ProductoController::class, 'busqueda']);

require __DIR__.'/auth.php';
