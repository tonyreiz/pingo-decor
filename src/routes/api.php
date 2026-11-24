<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\ProjetoController;
<<<<<<< HEAD

Route::prefix('v1')->group(function (){
    Route::get('/status', [StatusController::class, 'index']);

    Route::get('/projetos', [ProjetoController::class,'index']);
});
=======
use App\Http\Controllers\Api\V1\FavoritoController;
use App\Http\Controllers\Api\V1\FormularioController;
use App\Http\Controllers\Api\V1\AtualizacaoObraController;
use App\Http\Controllers\Api\V1\DepoimentoController;


Route::prefix('v1')->group(function () {


    // Status da API
    Route::get('/status', [StatusController::class, 'index']);

    // PROJETOS
    Route::get('/projetos', [ProjetoController::class, 'index']);

    // FAVORITOS
    Route::get('/favoritos', [\App\Http\Controllers\Api\V1\FavoritoController::class, 'index']);
    Route::post('/favoritos', [\App\Http\Controllers\Api\V1\FavoritoController::class, 'store']);
    Route::delete('/favoritos/{id}', [\App\Http\Controllers\Api\V1\FavoritoController::class, 'destroy']);

    // ATUALIZAÇÕES DA OBRA
    Route::get('/projetos/{id_projetos}/atualizacoes', [AtualizacaoObraController::class, 'index']);
    Route::post('/projetos/{id_projetos}/atualizacoes', [AtualizacaoObraController::class, 'store']);

    // DEPOIMENTOS
    Route::get('/depoimentos', [DepoimentoController::class, 'index']);
    Route::post('/depoimentos', [DepoimentoController::class, 'store']);

    // FORMULÁRIOS
    Route::post('/formularios', [FormularioController::class, 'store']);
});
>>>>>>> f30b79df22c92191e91a2d49923c7f17aebc471b
