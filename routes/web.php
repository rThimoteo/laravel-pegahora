<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

//Rotas para User
Route::group(['prefix' => '/user'], function (){

    Route::get('/', [UserController::class, 'index'])->name('users.get');

    Route::post('/store', [UserController::class, 'store'])->name('users.store');

    Route::get('/{user}', [UserController::class, 'show']);

    Route::put('/{user}', [UserController::class, 'update']);

    Route::delete('/{user}', [UserController::class, 'destroy']);
});

//Rotas para Address
Route::group(['prefix' => '/address'], function (){

    Route::get('/', [AddressController::class, 'index'])->name('addresses.get');

    Route::post('/store', [AddressController::class, 'store'])->name('addresses.store');

    Route::get('/{address}', [AddressController::class, 'show']);

    Route::put('/{address}', [AddressController::class, 'update']);

    Route::delete('/{address}', [AddressController::class, 'destroy']);
});

//Rotas para Company
Route::group(['prefix' => '/company'], function (){

    Route::get('/', [CompanyController::class, 'index'])->name('companies.get');

    Route::post('/store', [CompanyController::class, 'store'])->name('companies.store');

    Route::get('/{company}', [CompanyController::class, 'show']);

    Route::put('/{company}', [CompanyController::class, 'update']);

    Route::delete('/{company}', [CompanyController::class, 'destroy']);
});

