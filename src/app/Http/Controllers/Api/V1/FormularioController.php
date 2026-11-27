<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    // LISTAR FORMULÁRIOS
    public function index(): JsonResponse
    {
        $formularios = Formulario::orderBy('data_criacao_formulario', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Formulários consultados com sucesso',
            'total' => $formularios->count(),
            'data' => $formularios,
        ]);
    }

    // CONSULTAR FORMULÁRIO ESPECÍFICO
    public function show(int $id): JsonResponse
    {
        $formulario = Formulario::find($id);

        if (!$formulario) {
            return response()->json([
                'success' => false,
                'message' => 'Formulário não encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Formulário consultado com sucesso',
            'data' => $formulario,
        ]);
    }

    // CADASTRAR FORMULÁRIO
    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'endereco' => 'required|string|max:255',
            'profissao' => 'nullable|string|max:255',
            'tipo_projeto' => 'required|string|max:255',
            'metragem' => 'nullable|numeric',
            'prazo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        $formulario = Formulario::create([
            ...$dados,
            'status_formulario' => 'Novo',
            'data_criacao_formulario' => now(),
            'data_atualizacao_formulario' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Formulário enviado com sucesso',
            'data' => $formulario,
        ], 201);
    }
}
