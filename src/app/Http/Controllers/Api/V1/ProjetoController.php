<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Projetos;

class ProjetoController extends Controller
{
    //LISTAR TODOS OS PROJETOS
    public function index(): JsonResponse
    {
        $projetos = Projetos::where('status_projetos', 'Ativo')
            ->orderBy('nome_projetos', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Projetos consultados com sucesso',
            'total' => $projetos->count(),
            'data' => $projetos,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $projeto = Projetos::find($id);

        if (!$projeto) {
            return response()->json([
                'success' => false,
                'message' => 'Projeto não encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Projeto consultado com sucesso',
            'data' => $projeto,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'nome_projetos' => 'required|string|max:30',
            'imagem_projetos' => 'required|string|max:65',
            'status_projetos' => 'sometimes|in:Ativo,Inativo',
        ]);

        $dados['status_projetos'] = $dados['status_projetos'] ?? 'Ativo';
        $projeto = Projetos::create($dados);

        return response()->json([
            'success' => true,
            'message' => 'Projeto cadastrado com sucesso',
            'data' => $projeto,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $projeto = Projetos::find($id);

        if (!$projeto) {
            return response()->json([
                'success' => false,
                'message' => 'Projeto não encontrado',
            ], 404);
        }

        $dados = $request->validate([
            'nome_projetos' => 'required|string|max:30',
            'imagem_projetos' => 'required|string|max:65',
            'status_projetos' => 'required|in:Ativo,Inativo',
        ]);

        $projeto->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Projeto atualizado com sucesso',
            'data' => $projeto->refresh(),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $projeto = Projetos::find($id);

        if (!$projeto) {
            return response()->json([
                'success' => false,
                'message' => 'Projeto não encontrado',
            ], 404);
        }

        if ($projeto->atualizacoesObra()->exists() || $projeto->favoritos()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível excluir um projeto que possui atualizações ou favoritos vinculados',
            ], 409);
        }

        $projeto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Projeto excluído com sucesso',
        ]);
    }
}
