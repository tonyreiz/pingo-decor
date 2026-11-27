<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    // LISTAR AGENDAMENTOS
    public function index(): JsonResponse
    {
        $agendamentos = Agendamento::orderBy('dia_agendamento', 'desc')
            ->orderBy('horario_agendamento', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Agendamentos consultados com sucesso',
            'total' => $agendamentos->count(),
            'data' => $agendamentos,
        ]);
    }

    // CONSULTAR AGENDAMENTO
    public function show(int $id): JsonResponse
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return response()->json([
                'success' => false,
                'message' => 'Agendamento não encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Agendamento consultado com sucesso',
            'data' => $agendamento,
        ]);
    }

    // CRIAR AGENDAMENTO
    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'id_cliente' => 'required|integer|exists:tbl_cliente,id_cliente',
            'id_funcionario' => 'nullable|integer|exists:tbl_funcionario,id_funcionario',
            'dia_agendamento' => 'required|date',
            'horario_agendamento' => 'required|date_format:H:i',
            'endereco_agendamento' => 'required|string',
        ]);

        $dados['status_agendamento'] = 'Pendente';

        $agendamento = Agendamento::create($dados);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento cadastrado com sucesso',
            'data' => $agendamento,
        ], 201);
    }

    // ATUALIZAR AGENDAMENTO
    public function update(Request $request, int $id): JsonResponse
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return response()->json([
                'success' => false,
                'message' => 'Agendamento não encontrado',
            ], 404);
        }

        $dados = $request->validate([
            'id_cliente' => 'required|integer|exists:tbl_cliente,id_cliente',
            'id_funcionario' => 'present|nullable|integer|exists:tbl_funcionario,id_funcionario',
            'dia_agendamento' => 'required|date',
            'horario_agendamento' => 'required|date_format:H:i',
            'endereco_agendamento' => 'required|string',
            'status_agendamento' => 'required|in:Pendente,Confirmado,Cancelado',
        ]);

        $agendamento->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento atualizado com sucesso',
            'data' => $agendamento,
        ]);
    }

    // EXCLUIR AGENDAMENTO
    public function destroy(int $id): JsonResponse
    {
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return response()->json([
                'success' => false,
                'message' => 'Agendamento não encontrado',
            ], 404);
        }

        $agendamento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agendamento excluído com sucesso',
        ]);
    }
}
