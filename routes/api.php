<?php

use App\Http\Controllers\API\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('ultg/{id_parent}', [LocationController::class, 'ultg'])->name('api-ultg');
Route::get('gardu_induk/{section_id}', [LocationController::class, 'garduInduk'])->name('api-gardu-induk');
Route::get('substationAll', [LocationController::class, 'garduIndukAll'])->name('api-gardu-induk-all');
Route::get('bay/{id_parent}', [LocationController::class, 'bays'])->name('api-bay');
Route::get('subsystem/{substation_id}', [LocationController::class, 'subsystem'])->name('api-subsystem');
