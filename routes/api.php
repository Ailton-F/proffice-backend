<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function(){
    Route::get('/{id}', 'UserController@show');
    Route::post('/', 'UserController@store');
    Route::patch('/{id}', 'UserController@update');
    Route::delete('/{id}', 'UserController@destroy');
});