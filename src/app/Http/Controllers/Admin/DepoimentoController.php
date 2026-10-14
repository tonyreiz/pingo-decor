<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depoimento;
use Illuminate\Http\Request;

class DepoimentoController extends Controller
{
    public function index(Request $request)
    {
        $consulta = Depoimento::with('cliente');

        // Pesquisa por título, descrição ou nome do cliente
        if ($request->filled('busca')) {
            $busca = $request->busca;

            $consulta->where(function ($query) use ($busca) {
                $query->where('titulo_depoimento', 'like', "%{$busca}%")
                    ->orWhere('descricao_depoimento', 'like', "%{$busca}%")
                    ->orWhereHas('cliente', function ($cliente) use ($busca) {
                        $cliente->where('nome_cliente', 'like', "%{$busca}%");
                    });
            });
        }

        // Filtro por status
        if (in_array($request->status, ['Ativo', 'Inativo'], true)) {
            $consulta->where('status_depoimento', $request->status);
        }

        $listaDepoimento = $consulta
            ->orderByDesc('id_depoimento')
            ->get();

        // Resumo geral, independente dos filtros
        $totalDepoimentos = Depoimento::count();

        $totalAtivos = Depoimento::where(
            'status_depoimento',
            'Ativo'
        )->count();

        $totalInativos = Depoimento::where(
            'status_depoimento',
            'Inativo'
        )->count();

        $mediaNotas = Depoimento::avg('nota_depoimento') ?? 0;

        return view('admin.depoimento.index', compact(
            'listaDepoimento',
            'totalDepoimentos',
            'totalAtivos',
            'totalInativos',
            'mediaNotas'
        ));
    }

public function status(Request $request, $id)
{
    $dados = $request->validate([
        'status_depoimento' => 'required|in:Ativo,Inativo',
    ]);

    $depoimento = Depoimento::findOrFail($id);

    $depoimento->update([
        'status_depoimento' => $dados['status_depoimento'],
    ]);

    return redirect()
        ->route('admin.depoimento.index')
        ->with('sucesso', 'Status do depoimento atualizado com sucesso!');
}
}
