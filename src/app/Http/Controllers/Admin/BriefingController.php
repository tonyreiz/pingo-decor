<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Briefing;
use App\Models\Projetos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BriefingController extends Controller
{
    public function index(): View
    {
        $briefings = Briefing::query()
            ->join('tbl_projetos', 'tbl_projetos.id_projetos', '=', 'tbl_briefing.id_projetos')
            ->select('tbl_briefing.*', 'tbl_projetos.nome_projetos')
            ->orderByDesc('tbl_briefing.data_atualizacao_briefing')
            ->paginate(15);

        $projetosDisponiveis = Projetos::query()
            ->whereNotIn('id_projetos', Briefing::query()->select('id_projetos'))
            ->orderBy('nome_projetos')
            ->get(['id_projetos', 'nome_projetos']);

        return view('admin.briefing.index', compact('briefings', 'projetosDisponiveis'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'id_projetos' => ['required', 'integer', 'exists:tbl_projetos,id_projetos', 'unique:tbl_briefing,id_projetos'],
            'conteudo_briefing' => ['required', 'string', 'json'],
        ]);

        $conteudo = json_decode($dados['conteudo_briefing'], true);
        if (! is_array($conteudo) || $conteudo === []) {
            return back()->withInput()->withErrors(['conteudo_briefing' => 'Informe um objeto ou lista JSON com pelo menos um campo.']);
        }

        Briefing::create([
            'id_projetos' => $dados['id_projetos'],
            'conteudo_briefing' => $conteudo,
        ]);

        return redirect()->route('admin.briefing.index')->with('sucesso', 'Briefing criado com sucesso.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request->validate([
            'conteudo_briefing' => ['required', 'string', 'json'],
        ]);

        $conteudo = json_decode($dados['conteudo_briefing'], true);
        if (! is_array($conteudo) || $conteudo === []) {
            return back()->withInput()->withErrors(['conteudo_briefing' => 'Informe um objeto ou lista JSON com pelo menos um campo.']);
        }

        Briefing::findOrFail($id)->update(['conteudo_briefing' => $conteudo]);

        return redirect()->route('admin.briefing.index')->with('sucesso', 'Briefing atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Briefing::findOrFail($id)->delete();

        return redirect()->route('admin.briefing.index')->with('sucesso', 'Briefing excluído com sucesso.');
    }
}
