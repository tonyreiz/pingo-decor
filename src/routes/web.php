<?php

use App\Http\Controllers\Site\ContatoController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProjetosController;
use App\Http\Controllers\Site\PublicacoesController;
use App\Http\Controllers\Site\SobreController;

use Illuminate\Support\Facades\Route;

// area administrativa
use App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Admin\BannerController;
use \App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ContatoController as AdminContatoController;
use App\Http\Controllers\Admin\OrcamentoController;
use App\Http\Controllers\Admin\ProjetosController as AdminProjetosController;
use App\Http\Controllers\Admin\PublicacoesController as AdminPublicacoesController;
use App\Http\Controllers\Admin\DepoimentoController;
use App\Http\Controllers\Admin\FuncionarioController;
use App\Http\Controllers\Admin\AgendamentoController;
use App\Http\Controllers\Admin\LoginController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/sobre', [SobreController::class, 'sobre'])->name('sobre');
Route::get('/projetos', [ProjetosController::class, 'index'])->name('projetos.index');
Route::get('/projetos/{projeto}', [ProjetosController::class, 'show'])->name('projetos.show');
Route::get('/publicacoes', [PublicacoesController::class, 'index'])->name('publicacoes');
Route::get('/contato', [ContatoController::class, 'contato'])->name('contato');

// Os endereços antigos continuam funcionando como redirecionamentos.
Route::redirect('/index.html', '/');
Route::redirect('/sobre.html', '/sobre');
Route::redirect('/+projetos.html', '/projetos');
Route::redirect('/publicacoes.html', '/publicacoes');
Route::redirect('/contato.html', '/contato');
Route::redirect('/quarto-olivia.html', '/projetos/quarto-olivia');
Route::redirect('/quarto-matteo.html', '/projetos/quarto-matteo');
Route::redirect('/quarto-lucca.html', '/projetos/quarto-lucca');
Route::redirect('/quarto-julia-isabella.html', '/projetos/quarto-julia-isabella');
Route::redirect('/quarto-joaquim.html', '/projetos/quarto-joaquim');
Route::redirect('/quarto-dan-ava.html', '/projetos/quarto-dan-ava');
Route::redirect('/quarto-catarina.html', '/projetos/quarto-catarina');
Route::redirect('/quarto-benjamin.html', '/projetos/quarto-benjamin');
Route::redirect('/quarto-alice-catarina.html', '/projetos/quarto-alice-catarina');
Route::redirect('/brinquedoteca.html', '/projetos/brinquedoteca');


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
|
| O middleware guest permite acessar estas rotas somente quando o usuário NÃO está autenticado.
|
*/

Route::middleware('guest')->group(function () {

    // Exibir tela de login
    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    // Processar login
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.auth');
});

Route::middleware('auth')->group(function () {


    // --------------------------------------------------------------------------
    //     | LOGOUT
    //     |--------------------------------------------------------------------------
    //     */

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');




    // Painel administrativo.
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamento.index');
        Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamento.store');
        Route::put('/agendamentos/{id}', [AgendamentoController::class, 'update'])->name('agendamento.update');
        Route::delete('/agendamentos/{id}', [AgendamentoController::class, 'destroy'])->name('agendamento.destroy');

        Route::get('/banners', [BannerController::class, 'index'])->name('banner.index');
        Route::post('/banners', [BannerController::class, 'store'])->name('banner.store');
        Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banner.update');
        Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banner.destroy');

        Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente.index');
        Route::post('/cliente', [ClienteController::class, 'store'])->name('cliente.store');
        Route::put('/cliente/{id}', [ClienteController::class, 'update'])->name('cliente.update');
        Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');

       


        Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionario.index');
        Route::post('/funcionarios', [FuncionarioController::class, 'store'])->name('funcionario.store');
        Route::put('/funcionarios/{id}', [FuncionarioController::class, 'update'])->name('funcionario.update');
        Route::delete('/funcionarios/{id}', [FuncionarioController::class, 'destroy'])->name('funcionario.destroy');

        Route::get('/publicacoes', [AdminPublicacoesController::class, 'index'])->name('publicacoes.index');
        Route::post('/publicacoes', [AdminPublicacoesController::class, 'store'])->name('publicacoes.store');
        Route::put('/publicacoes/{id}', [AdminPublicacoesController::class, 'update'])->name('publicacoes.update');
        Route::delete('/publicacoes/{id}', [AdminPublicacoesController::class, 'destroy'])->name('publicacoes.destroy');

        Route::get('/projetos', [AdminProjetosController::class, 'index'])->name('projetos.index');
        Route::post('/projetos', [AdminProjetosController::class, 'store'])->name('projetos.store');
        Route::put('/projetos/{id}', [AdminProjetosController::class, 'update'])->name('projetos.update');
        Route::delete('/projetos/{id}', [AdminProjetosController::class, 'destroy'])->name('projetos.destroy');

        Route::get('/orcamento', [OrcamentoController::class, 'index'])->name('orcamento.index');
        Route::post('/orcamento', [OrcamentoController::class, 'store'])->name('orcamento.store');
        Route::put('/orcamento/{id}', [OrcamentoController::class, 'update'])->name('orcamento.update');
        Route::delete('/orcamento/{id}', [OrcamentoController::class, 'destroy'])->name('orcamento.destroy');

        Route::get('/depoimentos', [DepoimentoController::class, 'index'])->name('depoimento.index');
        Route::put('/depoimentos/{id}', [DepoimentoController::class, 'update'])->name('depoimento.update');
        Route::patch('/depoimentos/{id}/status', [DepoimentoController::class, 'status'])->name('depoimento.status');
    });
});
