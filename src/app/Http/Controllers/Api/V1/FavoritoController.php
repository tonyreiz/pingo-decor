<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Favoritos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    // LISTAR TODOS OS FAVORITOS
    public function index(): JsonResponse
    {
        $favoritos = Favoritos::orderBy('data_criacao_favorito', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Favoritos consultados com sucesso',
            'total' => $favoritos->count(),
            'data' => $favoritos,
        ]);
    }

    // ADICIONAR UM PROJETO AOS FAVORITOS
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_cliente' => 'required|integer',
            'id_projetos' => 'required|integer',
        ]);

        $favorito = Favoritos::create([
            'id_cliente' => $request->id_cliente,
            'id_projetos' => $request->id_projetos,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Projeto adicionado aos favoritos com sucesso',
            'data' => $favorito,
        ], 201);
    }

    // REMOVER UM FAVORITO
    public function destroy(int $id): JsonResponse
    {
        $favorito = Favoritos::find($id);

        if (!$favorito) {
            return response()->json([
                'success' => false,
                'message' => 'Favorito não encontrado',
            ], 404);
        }

        $favorito->delete();

        return response()->json([
            'success' => true,
            'message' => 'Projeto removido dos favoritos com sucesso',
        ]);
    }
}
