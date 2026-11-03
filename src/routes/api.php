<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\ProjetoController;


Route::prefix('v1')->group(function () {


    // Status da API
    Route::get('/status', [StatusController::class, 'index']);

    // PROJETOS
    Route::get('/projetos', [ProjetoController::class, 'index']);
});
