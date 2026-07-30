<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CliqueController;

Route::inertia('/', 'Landing')->name('home');
Route::post('/clique', [CliqueController::class, 'store']);