<?php

<<<<<<< HEAD
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
=======

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use illuminate\Http\JsonResponse;


class StatusController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'aplicacao' => 'Casa do Barista',
>>>>>>> f30b79df22c92191e91a2d49923c7f17aebc471b
                'api' => 'v1',
                'status' => 'online',
            ]
        ]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> f30b79df22c92191e91a2d49923c7f17aebc471b
