<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JogoController;

Route::get('/', [JogoController::class, 'home'])->name('home');
Route::get('/jogar/{dificuldade}', [JogoController::class, 'jogar'])->name('jogar');