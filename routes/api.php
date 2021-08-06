
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegionesController;
use App\Http\Controllers\ProvinciasController;
use App\Http\Controllers\ComunasController;

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

Route::prefix('regiones')->group(function (){
    Route::get('/', [RegionesController::class, 'index']);
    Route::get('/{codigo}', [RegionesController::class, 'show']);
});

Route::prefix('provincias')->group(function (){
    Route::get('/', [ProvinciasController::class, 'index']);
    Route::get('/{codigo}', [ProvinciasController::class, 'show']);
    Route::get('/region/{codigo}', [ProvinciasController::class, 'region']);
});

Route::prefix('comunas')->group(function (){
    Route::get('/', [ComunasController::class, 'index']);
    Route::get('/{codigo}', [ComunasController::class, 'show']);
    Route::get('/provincia/{codigo}', [ComunasController::class, 'provincia']);
    Route::get('/region/{codigo}', [ComunasController::class, 'region']);
});

Route::get('/climate/{region}', [RegionesController::class, 'climate']);
