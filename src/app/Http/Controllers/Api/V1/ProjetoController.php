<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Projetos;

class ProjetoController extends Controller
{
    //LISTAR TODOS OS PROJETOS
    public function index(): JsonResponse{

        // CONSULTAR OS PRODUTOS NO BANCO

        $projeto = Projetos::where('status_projetos', 'Ativo' )
        ->orderBy('nome_projetos', 'asc')
        ->get();

        // SEMPRE VAI SER ESPONSE NO FROMATO JSON
        return response()->json([
            // VERIFICAÇÃO

            'success' => true,
            'message' => 'Projetos consultados com sucesso',
            'total' => $projeto->count(),

            // DATA ARMAZENA OS DADOS DO PROJETO
            'data' => $projeto
        ], 200);
    
    }
}
