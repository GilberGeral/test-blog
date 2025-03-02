<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/autor/crear', 'App\Http\Controllers\AutorController@crear');
Route::post('/autor/actualizar', 'App\Http\Controllers\AutorController@actualizar');
Route::post('/autor/borrar', 'App\Http\Controllers\AutorController@borrar');
Route::get('/autor/list', 'App\Http\Controllers\AutorController@getList');