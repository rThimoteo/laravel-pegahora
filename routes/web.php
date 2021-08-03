<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Auth;
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

//Set Middleware
Route::group(['middleware' => 'auth'], function (){

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/viacep/{cep}', [CepController::class, 'cepSearch']);

    //Rotas para User
    Route::group(['prefix' => '/user'], function (){

        Route::get('/', [UserController::class, 'index'])->name('users.get');

        Route::post('/store', [UserController::class, 'store'])->name('users.store');

        Route::get('/{user}', [UserController::class, 'show']);

        Route::put('/{user}', [UserController::class, 'update']);

        Route::delete('/{user}', [UserController::class, 'destroy']);

        Route::group(['prefix' => '/orderby'], function (){

            Route::get('/name', [UserController::class, 'orderByName']);

            Route::get('/email', [UserController::class, 'orderByEmail']);

            Route::get('/username', [UserController::class, 'orderByUsername']);

            Route::get('/name/desc', [UserController::class, 'orderByNameDesc']);

            Route::get('/email/desc', [UserController::class, 'orderByEmailDesc']);

            Route::get('/username/desc', [UserController::class, 'orderByUsernameDesc']);

        });
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

    Route::get('/addresses', function () {
        return view('addresses');
    });

    Route::get('/companies', function () {
        return view('companies');
    });

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
