<?php


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
                'api' => 'v1',
                'status' => 'online',
            ]
        ]);
    }
}