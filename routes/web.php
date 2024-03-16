<?php

use Illuminate\Support\Facades\Route;

//route resource
Route::resource('/belajars', \App\Http\Controllers\BelajarController::class);
Route::apiResource('/belajars', App\Http\Controllers\Api\BelajarController::class);