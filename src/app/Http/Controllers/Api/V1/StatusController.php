<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

// AS RESPOSTAS SAIRÁ EM JSON
use Illuminate\Http\JsonResponse;

class StatusController extends Controller
{

    // MÉTODO DE SAÍDA
    public function index(): JsonResponse
    {

        // RETORNA A RESPOSTA
        return response()->json([
            'success' => true,       
            'data' => [
                'aplicacao' => 'Pingo decor',
                'api' => 'v1',
                'status' => 'online',
            ]
        ]);
    }
}
