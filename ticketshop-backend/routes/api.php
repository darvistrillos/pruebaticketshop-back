<?php

use App\Http\Controllers\V1\ProductosController;
use App\Http\Controllers\V1\PedidosController;
use App\Http\Controllers\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('v1')->group(function () {
    //Prefijo V1, todo lo que este dentro de este grupo se accedera escribiendo v1 en el navegador, es decir /api/v1/*
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('productos', [ProductosController::class, 'index']);
    Route::get('productos/{ProID}', [ProductosController::class, 'show']);
    Route::get('pedidos', [PedidosController::class, 'index']);
    Route::get('pedidos/{PedID}', [PedidosController::class, 'show']);
    Route::group(['middleware' => ['jwt.verify']], function() {
        //Todo lo que este dentro de este grupo requiere verificación de usuario.
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('get-user', [AuthController::class, 'getUser']);
        Route::post('productos', [ProductosController::class, 'store']);
        Route::put('productos/{ProID}', [ProductosController::class, 'update']);
        Route::delete('productos/{ProID}', [ProductosController::class, 'destroy']);
        Route::post('pedidos', [PedidosController::class, 'store']);
        Route::put('pedidos/{PedID}', [PedidosController::class, 'update']);
        Route::delete('pedidos/{PedID}', [PedidosController::class, 'destroy']);
    });
});
