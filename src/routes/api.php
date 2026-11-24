<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\ProjetoController;

Route::prefix('v1')->group(function (){
    Route::get('/status', [StatusController::class, 'index']);

    Route::get('/projetos', [ProjetoController::class,'index']);
});