<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  return view('listar_posts');
});

Route::get('/admin', function () {
  return view('admin_posts');
});
