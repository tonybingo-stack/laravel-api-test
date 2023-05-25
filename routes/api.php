<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;

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

Route::group(['namespace' => 'api', 'middleware' => ['CORS']], function () {

    // users
    Route::post('/users/login', [UserController::class, 'signIn']);

    Route::group(['middleware' => ['auth:api']], function () {

        Route::post('/users/logout', [UserController::class, 'logout']);
        Route::get('/users/info', [UserController::class, 'profileDetail']);

    });
});

Route::group(['middleware' => ['auth:api', 'CORS']], function () {

    Route::resource('company', CompanyController::class);
    
    Route::resource('employee', EmployeeController::class);
});
