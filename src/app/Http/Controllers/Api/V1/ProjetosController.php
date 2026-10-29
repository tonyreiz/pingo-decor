<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Projetos;

class ProjetosController extends Controller
{
    // LISTAR TODOS OS PROJETOS
    public function index(): JsonResponse
    {

        // 1- Consultar os projetos no banco
        $projetos = Projetos::where('status_projetos', 'Ativo')
        ->orderBy('nome_projetos', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'menssage' => 'Projetos consultados com secesso',
            'total' => $projetos->count(),
            'data' => $projetos
        ], 200);
    }
}
