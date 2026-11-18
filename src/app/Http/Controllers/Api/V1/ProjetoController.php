<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Projetos;



class ProjetoController extends Controller
{
    // LISTAR TODOS OS PROJETOS
    public function index(): JsonResponse
    {

        // 1- Consultar os projetos no banco de dados
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
}
