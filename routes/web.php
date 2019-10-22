<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Rutas Categorias
Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/activar', 'CategoriaController@activar');
Route::delete('/categoria/{categoria}/delete', 'CategoriaController@drop');
//Rutas roles
Route::get('/rol', 'RolController@index');
Route::post('/rol/nuevo', 'RolController@store');
Route::put('/rol/editar', 'RolController@edit');  
Route::delete('/rol/{rol}/delete','RolController@drop');
//Rutas permisos
Route::get('/permisos', 'PermisosController@index');
Route::get('/listaP', 'PermisosController@listarPermisos');
Route::put('/permisos/editar', 'PermisosController@edit');
Route::post('/rolPermiso/nuevo', 'PermisosController@store');
Route::delete('/rolPermiso/{rolP}/delete', 'PermisosController@drop');
//Rutas presentacion
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/presentacion', 'PresentacionController@index');
Route::post('/presentacion/registrar', 'PresentacionController@store');
Route::put('/presentacion/actualizar', 'PresentacionController@update');
Route::put('/presentacion/desactivar', 'PresentacionController@desactivar');
Route::put('/presentacion/activar', 'PresentacionController@activar');
Route::delete('/presentacion/{presentacion}/delete', 'PresentacionController@drop');
//Rutas proveedores
Route::get('/proveedores', 'ProveedorController@index');
Route::post('/proveedores/nuevo', 'ProveedorController@store');
Route::put('/proveedores/actualizar', 'ProveedorController@update');
Route::put('/proveedores/eliminar', 'ProveedorController@desactivar');

//Rutas clientes
Route::get('/clientes', 'ClienteController@index');
Route::post('/clientes/nuevo', 'ClienteController@store');
Route::put('/clientes/actualizar', 'ClienteController@update');
Route::put('/clientes/eliminar', 'ClienteController@desactivar');

//Rutas Productos
Route::get('/producto', 'ProductoController@index');
Route::post('/producto/registrar', 'ProductoController@store');
Route::put('/producto/actualizar', 'ProductoController@update');
Route::put('/producto/desactivar', 'ProductoController@desactivate');
//Rutas Personas
Route::get('/persona', 'PersonaController@index');
// Rutas de Historial de calidad
Route::get('/historialcalidad', 'HistorialcalidadController@index');
Route::post('/historialcalidad/registrar', 'HistorialcalidadController@store');
Route::put('/historialcalidad/actualizar', 'HistorialcalidadController@update');
Route::delete('/historialcalidad/{historialcalidad}/delete', 'HistorialcalidadController@drop');

// Rutas ventas
Route::post('/venta/nuevo', 'VentasController@store');
Route::get('/ventas/listar', 'VentasController@listarVentas');
Route::get('/ventas/validartotal', 'VentasController@validarTotal');
Route::delete('/venta/{id}/eliminar', 'VentasController@drop');
Route::post('/ventas/detalles','VentasController@detalleVenta');
Route::post('/ventas/factura', 'VentasController@generarFactura');
Route::post('/venta/cotizacion','VentasController@cotizacion');
Route::get('/venta/validadtotal','VentasController@validarTotal');
//Rutas usuarios
Route::get('/usuarios', 'UsuarioController@index');
Route::get('/rolCompras', 'UsuarioController@listarRolCompras');
Route::post('/usuario/registrar', 'UsuarioController@store');
Route::delete('usuario/{id}/delete', 'UsuarioController@drop');
Route::put('usuario/actualizar', 'UsuarioController@update');
Route::put('usuario/profile-update','UsuarioController@updateProfile')->name('profile.update');
Route::put('usuario/password-update','UsuarioController@updatePassword')->name('password.update');
Route::get('/usuario/inicios','LoginActivityController@inicio');    
// Rutas Caja
Route::get('/caja', 'CajaController@index');
Route::post('/caja/registrar', 'CajaController@store');
Route::get('/caja/estado', 'CajaController@estado');    
//Rutas compras
Route::post('/compra/nuevo', 'OrdenCompraController@generarOrden');
Route::post('/compra/orden', 'OrdenCompraController@imprimirOrden');
Route::get('/compra/ordenes', 'OrdenCompraController@index');
Route::get('/compra/detalles', 'OrdenCompraController@detalles');
Route::get('/compra/detallesGenerales', 'OrdenCompraController@indexGenerales');
Route::post('/compra/guardar','OrdenCompraController@finalizarOrden');
Route::post('/compra/editar','OrdenCompraController@editarOrden');
Route::delete('compra/{id}/eliminar', 'OrdenCompraController@drop');
//Route::get('/compra/{id}/detalles', 'OrdenCompraController@detalles');
Route::get('/compra/validartotal', 'OrdenCompraController@validarTotal');
Route::post('/compra/finalizada','OrdenCompraController@ordenFinalizada');
Route::get('/compra/validartotal','OrdenCompraController@validarTotal');
Route::post('/compra/reportegeneral','OrdenCompraController@reporteGeneral');
Route::get('/compra/comprassemana','OrdenCompraController@obtenerComprasSemana');
Route::get('/compra/comprasdia','OrdenCompraController@obtenerComprasDia');
Route::get('/compra/compraspendientes','OrdenCompraController@pendientes');
//RUTAS REPORTES
Route::post('/ventas/reporteProductos', 'VentasController@reporteVentasProducto');
Route::post('/ventas/reporteVClientes', 'VentasController@reporteVentasClientes');
Route::get('/reporteProveedores','ProveedorController@reporteGeneral');
Route::get('/reporteProveedores/{id}','ProveedorController@reporteEspecifico');
Route::get('/reporteClientes','ClienteController@reporteGeneral');
//RUTAS DATOS
Route::get('/mayorProv','ProveedorController@prov');
Route::get('/totalProvs','ProveedorController@totalProvs');
Route::get('/totalClientes','ClienteController@total');
Route::get('/mayorComprador','ClienteController@mayorComprador');
Route::get('/totalProds','ProductoController@totalProds');
Route::get('/ventas/totalSemana','VentasController@obtenerVentasSemana');
Route::get('/ventas/totalDia','VentasController@obtenerVentasDia');
Route::get('/ventas/productoGanancias','VentasController@productoMasGanancia');
Route::get('/ventas/productoMasVendido','VentasController@productoMasVendido');
Route::get('/ventas/productoMenosVendido','VentasController@productoMenosVendido');


Route::get('/test', function(){
    return 'HOLA';
});