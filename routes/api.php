<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('libros/crear', 'LibrosController@crear');
Route::middleware('auth:api')->delete('libros/eliminar/{id}', 'LibrosController@eliminar');
Route::middleware('auth:api')->put('libros/modificar/{id}', 'LibrosController@modificar');
Route::get('libros', 'LibrosController@mostrarTodos');
Route::get('libros/autor/{autor}', 'LibrosController@filtarPorAutor');
Route::get('libros/genero/{genero}', 'LibrosController@filtarPorGenero');

Route::middleware('auth:api')->post('usuarios/crear', 'UsersController@crear');
Route::middleware('auth:api')->get('usuarios', 'UsersController@mostrarTodos');

Route::middleware('auth:api')->post('prestamos/prestar','PrestamosController@prestar');
Route::middleware('auth:api')->put('prestamos/devolver','PrestamosController@devolver');
