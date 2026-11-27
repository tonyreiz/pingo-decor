<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ProjetoController;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\FormularioController;
use App\Http\Controllers\Api\V1\AtualizacaoObraController;
use App\Http\Controllers\Api\V1\DepoimentoController;
use App\Http\Controllers\Api\V1\AgendamentoController;
use App\Http\Controllers\Api\V1\FavoritoController;
use App\Http\Controllers\Api\V1\OrcamentoController;
use App\Http\Controllers\Api\V1\BriefingController;
use App\Http\Controllers\Api\V1\PerfilController;




Route::prefix('v1')->group(function () {


    // Status da API
    Route::get('/status', [StatusController::class, 'index']);

    // PERFIL DO CLIENTE
    Route::get('/profile', [PerfilController::class, 'show']);
    Route::put('/profile', [PerfilController::class, 'update']);
    Route::put('/profile/password', [PerfilController::class, 'updatePassword']);

    // PROJETOS
    Route::get('/projetos', [ProjetoController::class, 'index']);
    Route::get('/projetos/{id}', [ProjetoController::class, 'show'])->whereNumber('id');
    Route::post('/projetos', [ProjetoController::class, 'store']);
    Route::put('/projetos/{id}', [ProjetoController::class, 'update'])->whereNumber('id');
    Route::delete('/projetos/{id}', [ProjetoController::class, 'destroy'])->whereNumber('id');

    // BRIEFING DO PROJETO
    Route::post('/projetos/{id}/briefing', [BriefingController::class, 'store'])->whereNumber('id');
    Route::get('/projetos/{id}/briefing', [BriefingController::class, 'show'])->whereNumber('id');
    Route::put('/projetos/{id}/briefing', [BriefingController::class, 'update'])->whereNumber('id');

    // FAVORITOS
    Route::get('/favoritos', [\App\Http\Controllers\Api\V1\FavoritoController::class, 'index']);
    Route::post('/favoritos', [\App\Http\Controllers\Api\V1\FavoritoController::class, 'store']);
    Route::delete('/favoritos/{id}', [\App\Http\Controllers\Api\V1\FavoritoController::class, 'destroy']);

    // ATUALIZAÇÕES DA OBRA
    Route::get('/projetos/{id}/atualizacoes', [AtualizacaoObraController::class, 'index'])->whereNumber('id');
    Route::post('/projetos/{id}/atualizacoes', [AtualizacaoObraController::class, 'store'])->whereNumber('id');
    Route::get('/atualizacoes/{id}', [AtualizacaoObraController::class, 'show'])->whereNumber('id');
    Route::put('/atualizacoes/{id}', [AtualizacaoObraController::class, 'update'])->whereNumber('id');
    Route::delete('/atualizacoes/{id}', [AtualizacaoObraController::class, 'destroy'])->whereNumber('id');

    // DEPOIMENTOS
    Route::get('/depoimentos', [DepoimentoController::class, 'index']);
    Route::get('/depoimentos/{id}', [DepoimentoController::class, 'show'])->whereNumber('id');
    Route::post('/depoimentos', [DepoimentoController::class, 'store']);
    Route::put('/depoimentos/{id}', [DepoimentoController::class, 'update'])->whereNumber('id');
    Route::delete('/depoimentos/{id}', [DepoimentoController::class, 'destroy'])->whereNumber('id');

    // FORMULÁRIOS
    Route::get('/formularios', [FormularioController::class, 'index']);
    Route::get('/formularios/{id}', [FormularioController::class, 'show'])->whereNumber('id');
    Route::post('/formularios', [FormularioController::class, 'store']);

    // AGENDAMENTOS
    Route::get('/agendamentos', [AgendamentoController::class, 'index']);
    Route::post('/agendamentos', [AgendamentoController::class, 'store']);
    Route::get('/agendamentos/{id}', [AgendamentoController::class, 'show'])->whereNumber('id');
    Route::put('/agendamentos/{id}', [AgendamentoController::class, 'update'])->whereNumber('id');
    Route::delete('/agendamentos/{id}', [AgendamentoController::class, 'destroy'])->whereNumber('id');

    // ORÇAMENTOS
    Route::get('/orcamentos', [OrcamentoController::class, 'index']);
    Route::get('/orcamentos/{id}', [OrcamentoController::class, 'show'])->whereNumber('id');
    Route::post('/orcamentos', [OrcamentoController::class, 'store']);
    Route::put('/orcamentos/{id}', [OrcamentoController::class, 'update'])->whereNumber('id');
    Route::put('/orcamentos/{id}/status', [OrcamentoController::class, 'updateStatus'])->whereNumber('id');
});
