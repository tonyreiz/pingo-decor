<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AtualizacaoObra;
use App\Models\Projetos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtualizacaoObraController extends Controller
{
    public function index(int $id): JsonResponse
    {
        if (! Projetos::whereKey($id)->exists()) {
            return $this->notFound('Projeto não encontrado');
        }

        $atualizacoes = AtualizacaoObra::where('id_projetos', $id)
            ->orderBy('data_criacao_atualizacao_obra', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Atualizações consultadas com sucesso',
            'total' => $atualizacoes->count(),
            'data' => $atualizacoes,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $atualizacao = AtualizacaoObra::find($id);
        if (! $atualizacao) {
            return $this->notFound('Atualização não encontrada');
        }

        return response()->json([
            'success' => true,
            'message' => 'Atualização consultada com sucesso',
            'data' => $atualizacao,
        ]);
    }

    public function store(Request $request, int $id): JsonResponse
    {
        if (! Projetos::whereKey($id)->exists()) {
            return $this->notFound('Projeto não encontrado');
        }

        $dados = $request->validate([
            'id_funcionario' => ['required', 'integer', 'exists:tbl_funcionario,id_funcionario'],
            'descricao_atualizacao_obra' => ['required', 'string'],
            'imagem_atualizacao_obra' => ['nullable', 'string', 'max:255'],
        ]);

        $atualizacao = AtualizacaoObra::create([
            'id_projetos' => $id,
            ...$dados,
        ])->fresh();

        return response()->json([
            'success' => true,
            'message' => 'Atualização cadastrada com sucesso',
            'data' => $atualizacao,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $atualizacao = AtualizacaoObra::find($id);
        if (! $atualizacao) {
            return $this->notFound('Atualização não encontrada');
        }

        $dados = $request->validate([
            'id_funcionario' => ['sometimes', 'required', 'integer', 'exists:tbl_funcionario,id_funcionario'],
            'descricao_atualizacao_obra' => ['sometimes', 'required', 'string'],
            'imagem_atualizacao_obra' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        if ($dados === []) {
            return response()->json(['success' => false, 'message' => 'Informe ao menos um campo para atualizar'], 422);
        }

        $atualizacao->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Atualização editada com sucesso',
            'data' => $atualizacao->fresh(),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $atualizacao = AtualizacaoObra::find($id);
        if (! $atualizacao) {
            return $this->notFound('Atualização não encontrada');
        }

        $atualizacao->delete();

        return response()->json(['success' => true, 'message' => 'Atualização excluída com sucesso']);
    }

    private function notFound(string $message): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], 404);
    }
}
