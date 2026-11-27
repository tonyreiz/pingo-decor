<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Briefing;
use App\Models\Projetos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BriefingController extends Controller
{
    public function store(Request $request, int $id): JsonResponse
    {
        $projeto = Projetos::find($id);
        if (! $projeto) {
            return $this->notFound('Projeto não encontrado');
        }

        $dados = $this->validatedContent($request);
        if ($dados instanceof JsonResponse) {
            return $dados;
        }

        if (Briefing::where('id_projetos', $id)->exists()) {
            return response()->json(['success' => false, 'message' => 'O projeto já possui briefing'], 409);
        }

        $briefing = Briefing::create(['id_projetos' => $id, 'conteudo_briefing' => $dados]);

        return response()->json(['success' => true, 'message' => 'Briefing registrado com sucesso', 'data' => $briefing], 201);
    }

    public function show(int $id): JsonResponse
    {
        if (! Projetos::whereKey($id)->exists()) {
            return $this->notFound('Projeto não encontrado');
        }

        $briefing = Briefing::where('id_projetos', $id)->first();
        if (! $briefing) {
            return $this->notFound('Briefing não encontrado');
        }

        return response()->json(['success' => true, 'message' => 'Briefing consultado com sucesso', 'data' => $briefing]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        if (! Projetos::whereKey($id)->exists()) {
            return $this->notFound('Projeto não encontrado');
        }

        $briefing = Briefing::where('id_projetos', $id)->first();
        if (! $briefing) {
            return $this->notFound('Briefing não encontrado');
        }

        $dados = $this->validatedContent($request);
        if ($dados instanceof JsonResponse) {
            return $dados;
        }

        $briefing->update(['conteudo_briefing' => $dados]);

        return response()->json(['success' => true, 'message' => 'Briefing atualizado com sucesso', 'data' => $briefing->fresh()]);
    }

    private function validatedContent(Request $request): array|JsonResponse
    {
        $dados = $request->validate([
            'conteudo' => ['required', 'array'],
        ])['conteudo'];

        if ($dados === []) {
            return response()->json(['message' => 'O briefing deve conter ao menos um campo.'], 422);
        }

        return $dados;
    }

    private function notFound(string $message): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], 404);
    }
}

