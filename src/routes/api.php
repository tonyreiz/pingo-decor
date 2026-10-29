<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\ProjetosController;


Route::prefix('v1')->group(function(){

    //STATUS DA API
    Route::get('/status', [StatusController::class, 'index']);


    // PROJETOS
    Route::get('/projetos', [ProjetosController::class, 'index']);

});