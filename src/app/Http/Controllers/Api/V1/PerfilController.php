<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    /** Consultar o perfil identificado pelo id_cliente informado na query string. */
    public function show(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'id_cliente' => ['required', 'integer', 'exists:tbl_cliente,id_cliente'],
        ]);

        $cliente = Cliente::findOrFail($dados['id_cliente']);

        return response()->json([
            'success' => true,
            'message' => 'Perfil consultado com sucesso',
            'data' => $this->dadosPublicos($cliente),
        ]);
    }

    /** Atualizar dados básicos do perfil. */
    public function update(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'id_cliente' => ['required', 'integer', 'exists:tbl_cliente,id_cliente'],
            'nome_cliente' => ['sometimes', 'required', 'string', 'max:50'],
            'email_cliente' => [
                'sometimes', 'required', 'email', 'max:80',
                Rule::unique('tbl_cliente', 'email_cliente')->ignore($request->input('id_cliente'), 'id_cliente'),
            ],
            'telefone_cliente' => ['sometimes', 'nullable', 'string', 'max:20'],
        ]);

        $cliente = Cliente::findOrFail($dados['id_cliente']);
        $cliente->fill(collect($dados)->except('id_cliente')->all());
        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => 'Perfil atualizado com sucesso',
            'data' => $this->dadosPublicos($cliente->fresh()),
        ]);
    }

    /** Alterar senha após confirmar a senha atual. */
    public function updatePassword(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'id_cliente' => ['required', 'integer', 'exists:tbl_cliente,id_cliente'],
            'senha_atual' => ['required', 'string'],
            'nova_senha' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $cliente = Cliente::findOrFail($dados['id_cliente']);

        if (!Hash::check($dados['senha_atual'], $cliente->senha_cliente)) {
            return response()->json([
                'success' => false,
                'message' => 'A senha atual está incorreta',
            ], 422);
        }

        $cliente->senha_cliente = $dados['nova_senha'];
        $cliente->save();

        return response()->json([
            'success' => true,
            'message' => 'Senha alterada com sucesso',
        ]);
    }

    private function dadosPublicos(Cliente $cliente): array
    {
        return [
            'id_cliente' => $cliente->id_cliente,
            'nome_cliente' => $cliente->nome_cliente,
            'email_cliente' => $cliente->email_cliente,
            'telefone_cliente' => $cliente->telefone_cliente,
            'foto_cliente' => $cliente->foto_cliente,
            'foto_url' => $cliente->photoUrl(),
            'status_cliente' => $cliente->status_cliente,
            'data_criacao_cliente' => $cliente->data_criacao_cliente,
            'data_atualizacao_cliente' => $cliente->data_atualizacao_cliente,
        ];
    }
}
