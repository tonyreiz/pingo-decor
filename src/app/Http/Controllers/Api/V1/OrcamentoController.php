<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Orcamento;
use Illuminate\Validation\Rule;
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
        $dados = $request->validate([
            'id_cliente' => 'required|integer|exists:tbl_cliente,id_cliente',
            'titulo_orcamento' => 'required|string|max:50',
            'valor_total_orcamento' => 'required|numeric|min:0',
            'prazo_execucao_orcamento' => 'required|string|max:65535',
            'observacoes_orcamento' => 'nullable|string|max:65535',
        ]);

        $orcamento = Orcamento::create([
            ...$dados,
            'observacoes_orcamento' => $dados['observacoes_orcamento'] ?? '',
            'status_orcamento' => 'Pendente',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orçamento cadastrado com sucesso',
            'data' => $orcamento,
        ], 201);
    }

    // ATUALIZAR DADOS DO ORÇAMENTO
    public function update(Request $request, int $id): JsonResponse
    {
        $orcamento = Orcamento::find($id);
        if (!$orcamento) {
            return response()->json(['success' => false, 'message' => 'Orçamento não encontrado'], 404);
        }

        $dados = $request->validate([
            'id_cliente' => ['sometimes', 'required', 'integer', 'exists:tbl_cliente,id_cliente'],
            'titulo_orcamento' => ['sometimes', 'required', 'string', 'max:50'],
            'valor_total_orcamento' => ['sometimes', 'required', 'numeric', 'min:0'],
            'prazo_execucao_orcamento' => ['sometimes', 'required', 'string', 'max:65535'],
            'observacoes_orcamento' => ['sometimes', 'nullable', 'string', 'max:65535'],
        ]);

        $orcamento->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Orçamento atualizado com sucesso',
            'data' => $orcamento->fresh(),
        ]);
    }

    // ATUALIZAR SITUAÇÃO DO ORÇAMENTO
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $orcamento = Orcamento::find($id);
        if (!$orcamento) {
            return response()->json(['success' => false, 'message' => 'Orçamento não encontrado'], 404);
        }

        $dados = $request->validate([
            'status_orcamento' => ['required', 'string', Rule::in(['Pendente', 'Aprovado', 'Analise'])],
        ]);

        $orcamento->update(['status_orcamento' => $dados['status_orcamento']]);

        return response()->json([
            'success' => true,
            'message' => 'Situação do orçamento atualizada com sucesso',
            'data' => $orcamento->fresh(),
        ]);
    }
}
