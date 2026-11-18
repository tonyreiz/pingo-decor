<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Orcamento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrcamentoController extends Controller
{
    // LISTAR ORÇAMENTOS
    public function index(): JsonResponse
    {
        $orcamentos = Orcamento::orderBy('data_criacao_orcamento', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Orçamentos consultados com sucesso',
            'total' => $orcamentos->count(),
            'data' => $orcamentos,
        ]);
    }

    // CONSULTAR UM ORÇAMENTO
    public function show(int $id): JsonResponse
    {
        $orcamento = Orcamento::find($id);

        if (!$orcamento) {
            return response()->json([
                'success' => false,
                'message' => 'Orçamento não encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orçamento consultado com sucesso',
            'data' => $orcamento,
        ]);
    }

    // CADASTRAR ORÇAMENTO
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_cliente' => 'required|integer',
            'titulo_orcamento' => 'required|string|max:50',
            'valor_total_orcamento' => 'required|numeric',
            'prazo_execucao_orcamento' => 'required|string',
            'observacoes_orcamento' => 'required|string',
        ]);

        $orcamento = Orcamento::create([
            'id_cliente' => $request->id_cliente,
            'titulo_orcamento' => $request->titulo_orcamento,
            'valor_total_orcamento' => $request->valor_total_orcamento,
            'prazo_execucao_orcamento' => $request->prazo_execucao_orcamento,
            'observacoes_orcamento' => $request->observacoes_orcamento,
            'status_orcamento' => 'Pendente',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orçamento cadastrado com sucesso',
            'data' => $orcamento,
        ], 201);
    }
}