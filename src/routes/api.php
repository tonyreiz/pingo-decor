<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\ProjetosController;
use App\Http\Controllers\Api\V1\FavoritoController;
use App\Http\Controllers\Api\V1\FormularioController;
use App\Http\Controllers\Api\V1\AtualizacaoObraController;
use App\Http\Controllers\Api\V1\DepoimentoController;

Route::prefix('v1')->group(function () {

    // STATUS DA API
    Route::get('/status', [StatusController::class, 'index']);

    // PROJETOS
    Route::get('/projetos', [ProjetosController::class, 'index']);

    // FAVORITOS
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos', [FavoritoController::class, 'store']);
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'destroy']);

    // ATUALIZAÇÕES DA OBRA
    Route::get('/projetos/{id_projetos}/atualizacoes', [AtualizacaoObraController::class, 'index']);
    Route::post('/projetos/{id_projetos}/atualizacoes', [AtualizacaoObraController::class, 'store']);

    // DEPOIMENTOS
    Route::get('/depoimentos', [DepoimentoController::class, 'index']);
    Route::post('/depoimentos', [DepoimentoController::class, 'store']);

    // FORMULÁRIOS
    Route::post('/formularios', [FormularioController::class, 'store']);

});
