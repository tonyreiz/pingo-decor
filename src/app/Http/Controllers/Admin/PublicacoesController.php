<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publicacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicacoesController extends Controller
{
    public function index(): View
    {
        $listarPublicacoes = Publicacoes::orderByDesc('data_publicacoes')->get();

        return view('admin.publicacoes.index', compact('listarPublicacoes'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo_publicacoes' => 'required|string|max:100',
            'descricao_publicacoes' => 'required|string',
            'imagem_publicacoes' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'link_publicacoes' => 'required|url|max:255',
            'data_publicacoes' => 'required|date',
        ]);

        

        $novoArquivo = null;

        try {
            DB::beginTransaction();

            $publicacao = Publicacoes::create([
                'titulo_publicacoes' => $dados['titulo_publicacoes'],
                'descricao_publicacoes' => $dados['descricao_publicacoes'],
                'imagem_publicacoes' => 'publicacao/sem-foto.png',
                'link_publicacoes' => $dados['link_publicacoes'],
                'data_publicacoes' => $dados['data_publicacoes'],
            ]);

            $caminhoRelativo = $this->salvarImagem($request->file('imagem_publicacoes'), $publicacao);
            $novoArquivo = public_path('pingo-decor/assets/publicacao' . $caminhoRelativo);
            $publicacao->update(['imagem_publicacoes' => $caminhoRelativo]);

            DB::commit();

            return redirect()
                ->route('admin.publicacoes.index')
                ->with('sucesso', 'Publicação cadastrada com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            $this->excluirArquivoFisico($novoArquivo);
            report($erro);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Não foi possível cadastrar a publicação. Tente novamente.');
        }
    }

    public function update(Request $request, int $id)
    {
        $dados = $request->validate([
            'titulo_publicacoes' => 'required|string|max:100',
            'descricao_publicacoes' => 'required|string',
            'imagem_publicacoes' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'link_publicacoes' => 'required|url|max:255',
            'data_publicacoes' => 'required|date',
        ]);

        $publicacao = Publicacoes::findOrFail($id);
        $imagemAntiga = $publicacao->imagem_publicacoes;
        $novoArquivo = null;

        try {
            DB::beginTransaction();

            $caminhoImagem = $imagemAntiga;

            if ($request->hasFile('imagem_publicacoes')) {
                $caminhoImagem = $this->salvarImagem($request->file('imagem_publicacoes'), $publicacao, $dados['titulo_publicacoes']);
                $novoArquivo = public_path('pingo-decor/assets/publicacao' . $caminhoImagem);
            }

            $publicacao->update([
                'titulo_publicacoes' => $dados['titulo_publicacoes'],
                'descricao_publicacoes' => $dados['descricao_publicacoes'],
                'imagem_publicacoes' => $caminhoImagem,
                'link_publicacoes' => $dados['link_publicacoes'],
                'data_publicacoes' => $dados['data_publicacoes'],
            ]);

            DB::commit();

            if ($caminhoImagem !== $imagemAntiga) {
                $this->excluirImagem($imagemAntiga);
            }

            return redirect()
                ->route('admin.publicacoes.index')
                ->with('sucesso', 'Publicação atualizada com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            $this->excluirArquivoFisico($novoArquivo);
            report($erro);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Não foi possível atualizar a publicação. Tente novamente.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $publicacao = Publicacoes::findOrFail($id);
            $imagem = $publicacao->imagem_publicacoes;

            $publicacao->delete();
            $this->excluirImagem($imagem);

            return redirect()
                ->route('admin.publicacoes.index')
                ->with('sucesso', 'Publicação excluída com sucesso!');
        } catch (\Throwable $erro) {
            report($erro);

            return redirect()
                ->back()
                ->with('erro', 'Não foi possível excluir a publicação. Tente novamente.');
        }
    }

    private function salvarImagem($imagem, Publicacoes $publicacao, ?string $titulo = null): string
    {
        $slug = Str::limit(Str::slug($titulo ?? $publicacao->titulo_publicacoes), 50, '');
        $extensao = strtolower($imagem->getClientOriginalExtension());
        $nomeImagem = $slug . '_' . $publicacao->id_publicacoes . '_' . Str::lower(Str::random(6)) . '.' . $extensao;
        $pasta = public_path('pingo-decor/assets/publicacao');

        if (!is_dir($pasta)) {
            mkdir($pasta, 0775, true);
        }

        $imagem->move($pasta, $nomeImagem);

        return 'publicacao/' . $nomeImagem;
    }

    private function excluirImagem(?string $caminhoRelativo): void
    {
        if (!$caminhoRelativo || !str_starts_with($caminhoRelativo, 'publicacao/')) {
            return;
        }

        $this->excluirArquivoFisico(public_path('pingo-decor/assets/publicacao/' . $caminhoRelativo));
    }

    private function excluirArquivoFisico(?string $caminho): void
    {
        if ($caminho && is_file($caminho)) {
            unlink($caminho);
        }
    }
}
