<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class FormularioController extends Controller
{
    public function index()
    {
        $formularios = Formulario::all();

        return response()->json($formularios);
    }

    public function store(Request $request)
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

        $formulario = Formulario::create($dados + [
            'status_formulario' => 'Novo',
            'data_criacao_formulario' => now(),
            'data_atualizacao_formulario' => now(),
        ]);

        return response()->json([
            'mensagem' => 'Formulário enviado com sucesso!',
            'formulario' => $formulario
        ], 201);
    }

    public function show($id)
    {
        $formulario = Formulario::find($id);

        if (!$formulario) {
            return response()->json([
                'mensagem' => 'Formulário não encontrado.'
            ], 404);
        }

        return response()->json($formulario);
    }
}
