<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Users Routers
Route::post('user/register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['jwt.verify:admin,kasir,owner']], function () {
    Route::get('login/check', [UserController::class, 'loginCheck']);
    Route::post('user/logout', [UserController::class, 'logout']);

    Route::get('outlet', [OutletController::class, 'getAll']);
    Route::get('outlet/{id_outlet}', [OutletController::class, 'getById']);

    Route::post('transaksi/report', [TransaksiController::class, 'report']);
});

Route::group(['middleware' => ['jwt.verify:admin,kasir']], function () {
    // Member Routers
    Route::post('member', [MemberController::class, 'insert']);
    Route::put('member/{id_member}', [MemberController::class, 'update']);
    Route::delete('member/{id_member}', [MemberController::class, 'delete']);
    Route::get('member', [MemberController::class, 'getAll']);
    Route::get('member/{id_member}', [MemberController::class, 'getById']);
    // Paket Routers
    Route::post('paket', [PaketController::class, 'insert']);
    Route::put('paket/{id_paket}', [PaketController::class, 'update']);
    Route::delete('paket/{id_paket}', [PaketController::class, 'delete']);
    Route::get('paket', [PaketController::class, 'getAll']);
    Route::get('paket/{id_paket}', [PaketController::class, 'getById']);
    // Transaksi Routers
    Route::post('transaksi', [TransaksiController::class, 'insert']);
    Route::put('transaksi/status', [TransaksiController::class, 'update_status']);
    Route::put('transaksi/bayar', [TransaksiController::class, 'update_bayar']);
});

// Outlet Routers
Route::group(['middleware' => ['jwt.verify:admin']], function () {
    Route::post('outlet', [OutletController::class, 'insert']);
    Route::put('outlet/{id_outlet}', [OutletController::class, 'update']);
    Route::delete('outlet/{id_outlet}', [OutletController::class, 'delete']);
    
    Route::post('user', [UserController::class, 'insert']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);
    Route::get('user', [UserController::class, 'getAll']);
    Route::get('user/{id}', [UserController::class, 'getById']);
}); 
