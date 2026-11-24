<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AtualizacaoObra;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtualizacaoObraController extends Controller
{
    // LISTAR ATUALIZAÇÕES DE UM PROJETO
    public function index(int $id_projetos): JsonResponse
    {
        $atualizacoes = AtualizacaoObra::where('id_projetos', $id_projetos)
            ->orderBy('data_criacao_atualizacao_obra', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Atualizações consultadas com sucesso',
            'total' => $atualizacoes->count(),
            'data' => $atualizacoes,
        ]);
    }

    // CADASTRAR UMA ATUALIZAÇÃO
    public function store(Request $request, int $id_projetos): JsonResponse
    {
        $request->validate([
            'id_funcionario' => 'required|integer',
            'descricao_atualizacao_obra' => 'required|string',
            'tipo_atualizacao_obra' => 'required|in:obra,financeiro',
            'valor_atualizacao_obra' => 'nullable|numeric',
            'imagem_atualizacao_obra' => 'nullable|string|max:255',
        ]);

        $atualizacao = AtualizacaoObra::create([
            'id_projetos' => $id_projetos,
            'id_funcionario' => $request->id_funcionario,
            'descricao_atualizacao_obra' => $request->descricao_atualizacao_obra,
            'tipo_atualizacao_obra' => $request->tipo_atualizacao_obra,
            'valor_atualizacao_obra' => $request->valor_atualizacao_obra,
            'imagem_atualizacao_obra' => $request->imagem_atualizacao_obra,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Atualização cadastrada com sucesso',
            'data' => $atualizacao,
        ], 201);
    }
}