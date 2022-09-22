<?php

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

Route::group(['prefix' => 'problem'], function () {
    Route::get('fives/{start}/{end}','ProblemsController@ExceptFives');
    Route::get('alphabet/{input_string}','ProblemsController@AlphaString');
    Route::post('array','ProblemsController@ArrayNumbers');
});

Route::group(['prefix' => 'user'], function () {
    Route::post('login','UserController@Login');
    Route::post('register','UserController@Register');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('allusers','UserController@Show');
    Route::get('user/{id}','UserController@GetById');
    Route::post('edit','UserController@Edit');
    Route::get('delete/{id}','UserController@Delete');
});
