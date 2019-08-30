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
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');
Route::delete('/categoria/{categoria}/delete', 'CategoriaController@drop');
//Rutas roles
Route::get('/rol', 'RolController@index');
Route::post('/rol/nuevo', 'RolController@store');
Route::put('/rol/editar', 'RolController@edit');
//Rutas permisos
Route::get('/permisos', 'PermisosController@index');
Route::put('/permisos/editar', 'PermisosController@edit');
//Rutas presentacion
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/presentacion', 'PresentacionController@index');
Route::post('/presentacion/registrar', 'PresentacionController@store');
Route::put('/presentacion/actualizar', 'PresentacionController@update');
Route::put('/presentacion/desactivar', 'PresentacionController@desactivar');
Route::put('/presentacion/activar', 'PresentacionController@activar');
Route::delete('/presentacion/{presentacion}/delete', 'PresentacionController@drop');
