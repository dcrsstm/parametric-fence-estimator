<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrototypeController;

Route::get('/', function () {
    return view('prototype');
});

Route::post('/calculate', [PrototypeController::class, 'calculate']);