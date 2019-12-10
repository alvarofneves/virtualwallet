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

//WALLET API
Route::get('wallets', 'WalletControllerAPI@index');
Route::get('wallets/{id}', 'WalletControllerAPI@show');
Route::post('wallets', 'WalletControllerAPI@store');
Route::put('wallets/{id}', 'WalletControllerAPI@update');
//Route::delete('users/{id}', 'WalletControllerAPI@destroy');
//USER API
Route::get('users', 'UserControllerAPI@index');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
Route::get('users/{id}', 'UserControllerAPI@show');
Route::post('users', 'UserControllerAPI@store');
Route::put('users/{id}', 'UserControllerAPI@update');
Route::delete('users/{id}', 'UserControllerAPI@destroy');
//MOVEMENT API
Route::get('movements', 'MovementControllerAPI@index');
Route::get('movements/{id}', 'MovementControllerAPI@show_movement_id');
Route::post('movements', 'MovementControllerAPI@store');
//Route::delete('users/{id}', 'WalletControllerAPI@destroy');
//LOGIN API
Route::post('login', 'LoginControllerAPI@login');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id

Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
*/