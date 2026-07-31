<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

Route::get('/', [CityController::class, 'index']);
Route::get('/cities/{code}', [CityController::class, 'byCountry']);