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

    // CADASTRAR DEPOIMENTO
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_cliente' => 'required|integer',
            'id_orcamento' => 'required|integer',
            'titulo_depoimento' => 'required|string|max:50',
            'descricao_depoimento' => 'required|string',
            'nota_depoimento' => 'required|integer|min:1|max:5',
        ]);

        $depoimento = Depoimento::create([
            'id_cliente' => $request->id_cliente,
            'id_orcamento' => $request->id_orcamento,
            'titulo_depoimento' => $request->titulo_depoimento,
            'descricao_depoimento' => $request->descricao_depoimento,
            'nota_depoimento' => $request->nota_depoimento,
            'status_depoimento' => 'Pendente',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Depoimento enviado para aprovação',
            'data' => $depoimento,
        ], 201);
    }
}