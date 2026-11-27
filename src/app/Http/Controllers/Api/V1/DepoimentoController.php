<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Depoimento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepoimentoController extends Controller
{
    // LISTAR DEPOIMENTOS APROVADOS
    public function index(): JsonResponse
    {
        $depoimentos = Depoimento::where('status_depoimento', 'Aprovado')
            ->orderBy('data_criacao_depoimento', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Depoimentos consultados com sucesso',
            'total' => $depoimentos->count(),
            'data' => $depoimentos,
        ]);
    }

    // CONSULTAR DEPOIMENTO ESPECÍFICO
    public function show(int $id): JsonResponse
    {
        $depoimento = Depoimento::find($id);

        if (!$depoimento) {
            return response()->json([
                'success' => false,
                'message' => 'Depoimento não encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Depoimento consultado com sucesso',
            'data' => $depoimento,
        ]);
    }

    // CADASTRAR DEPOIMENTO
    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'id_cliente' => 'required|integer',
            'id_orcamento' => 'required|integer',
            'titulo_depoimento' => 'required|string|max:50',
            'descricao_depoimento' => 'required|string',
            'nota_depoimento' => 'required|integer|min:1|max:5',
        ]);

        $dados['status_depoimento'] = 'Pendente';

        $depoimento = Depoimento::create($dados);

        return response()->json([
            'success' => true,
            'message' => 'Depoimento enviado para aprovação',
            'data' => $depoimento,
        ], 201);
    }

    // ATUALIZAR DEPOIMENTO
    public function update(Request $request, int $id): JsonResponse
    {
        $depoimento = Depoimento::find($id);

        if (!$depoimento) {
            return response()->json([
                'success' => false,
                'message' => 'Depoimento não encontrado',
            ], 404);
        }

        $dados = $request->validate([
            'id_cliente' => 'required|integer',
            'id_orcamento' => 'required|integer',
            'titulo_depoimento' => 'required|string|max:50',
            'descricao_depoimento' => 'required|string',
            'nota_depoimento' => 'required|integer|min:1|max:5',
        ]);

        $depoimento->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Depoimento atualizado com sucesso',
            'data' => $depoimento,
        ]);
    }

    // EXCLUIR DEPOIMENTO
    public function destroy(int $id): JsonResponse
    {
        $depoimento = Depoimento::find($id);

        if (!$depoimento) {
            return response()->json([
                'success' => false,
                'message' => 'Depoimento não encontrado',
            ], 404);
        }

        $depoimento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Depoimento excluído com sucesso',
        ]);
    }
}
