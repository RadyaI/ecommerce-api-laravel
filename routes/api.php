<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\authController;
// use App\Models\karyawan;

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

//Auth
Route::post('/login', [authController::class, 'login']);
Route::post('/logout', [authController::class, 'logout'])->middleware(['auth:sanctum']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // Karyawan
    Route::get('/getKaryawan', [karyawanController::class, 'getKaryawan']);
    Route::get('/getKaryawan/{id}', [karyawanController::class, 'selectKaryawan']);
    Route::post('/createKaryawan', [karyawanController::class, 'createKaryawan']);
    Route::put('/updateKaryawan/{id}', [karyawanController::class, 'updateKaryawan']);
    Route::delete('/deleteKaryawan/{id}', [karyawanController::class, 'deleteKaryawan']);
});

Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {
});
