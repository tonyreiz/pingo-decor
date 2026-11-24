<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Formulario;

class ContatoController extends Controller
{
    public function contato(): View
    {
        return view('site.contato.contato');
    }

    public function enviar(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'endereco' => 'required|string|max:255',
            'profissao' => 'nullable|string|max:255',
            'tipo_projeto' => 'required|string|max:255',
            'metragem' => 'nullable|numeric|min:0',
            'prazo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:1000'
        ]);

        Formulario::create($dados + [
            'status_formulario' => 'Novo',
            'data_criacao_formulario' => now(),
            'data_atualizacao_formulario' => now(),
        ]);

        return redirect()->route('contato')->with('sucesso', 'Solicitação enviada! Entraremos em contato em breve.');
    }
}
