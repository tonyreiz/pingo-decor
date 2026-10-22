<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class FuncionarioController extends Controller
{
    public function index()
    {
        $listarFuncionario = Funcionario::orderByDesc('id_funcionario')
            ->get();
        return view('admin.funcionario.index', compact('listarFuncionario'));
    }


    

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_funcionario' => 'required|string|max:50',
            'email_funcionario' => 'required|email|max:80|unique:tbl_funcionario,email_funcionario',
            'senha_funcionario' => 'required|string|min:6|max:255',
            'telefone_funcionario' => 'required|string|min:6|max:15',
            'cargo_funcionario' => 'required|string|min:6|max:20',
            'foto_funcionario' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status_funcionario' => 'required|in:Ativo,Inativo',
        ]);

        $novoArquivo = null;

        try {
            DB::beginTransaction();

            $funcionario = Funcionario::create([
                'nome_funcionario' => $dados['nome_funcionario'],
                'email_funcionario' => $dados['email_funcionario'],
                'senha_funcionario' => Hash::make($dados['senha_funcionario']),
                'foto_funcionario' => 'funcionario/sem-foto.png',
                'cargo_funcionario' => $dados['cargo_funcionario'],
                'telefone_funcionario' => $dados['telefone_funcionario'],
                'status_funcionario' => $dados['status_funcionario'],
            ]);

            $caminhoRelativo = $this->salvarImagem($request->file('foto_funcionario'), $funcionario);
            $novoArquivo = public_path('pingo-decor/assets/' . $caminhoRelativo);
            $funcionario->update(['foto_funcionario' => $caminhoRelativo]);

            DB::commit();

            return redirect()
                ->route('admin.funcionario.index')
                ->with('sucesso', 'Funcionario cadastrado com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            $this->excluirArquivoFisico($novoArquivo);
            report($erro);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Não foi possível cadastrar o funcionario. Tente novamente.');
        }
    }

    public function update(Request $request, int $id)
    {
        $dados = $request->validate([
            'nome_funcionario' => 'required|string|max:50',
            'email_funcionario' => 'required|email|max:80|unique:tbl_funcionario,email_funcionario,' . $id . ',id_funcionario',
            'senha_funcionario' => 'nullable|string|min:6|max:255',
            'telefone_funcionario' => 'required|string|min:6|max:15',
            'cargo_funcionario' => 'required|string|min:6|max:20',
            'foto_funcionario' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status_funcionario' => 'required|in:Ativo,Inativo',
        ]);

        $funcionario = Funcionario::findOrFail($id);
        $fotoAntiga = $funcionario->foto_funcionario;
        $novoArquivo = null;

        try {
            DB::beginTransaction();

            $caminhoFoto = $fotoAntiga;

            if ($request->hasFile('foto_funcionario')) {
                $caminhoFoto = $this->salvarImagem($request->file('foto_funcionario'), $funcionario, $dados['nome_funcionario']);
                $novoArquivo = public_path('pingo-decor/assets/' . $caminhoFoto);
            }

            $dadosAtualizacao = [
                'nome_funcionario' => $dados['nome_funcionario'],
                'email_funcionario' => $dados['email_funcionario'],
                'telefone_funcionario' => $dados['telefone_funcionario'],
                'cargo_funcionario' => $dados['cargo_funcionario'],
                'foto_funcionario' => $caminhoFoto,
                'status_funcionario' => $dados['status_funcionario'],
            ];

            if (!empty($dados['senha_funcionario'])) {
                $dadosAtualizacao['senha_funcionario'] = Hash::make($dados['senha_funcionario']);
            }

            $funcionario->update($dadosAtualizacao);

            DB::commit();

            if ($caminhoFoto !== $fotoAntiga) {
                $this->excluirImagem($fotoAntiga);
            }

            return redirect()
                ->route('admin.funcionario.index')
                ->with('sucesso', 'Funcionario atualizado com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            $this->excluirArquivoFisico($novoArquivo);
            report($erro);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Não foi possível atualizar o funcionario. Tente novamente.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $funcionario = Funcionario::findOrFail($id);
            $foto = $funcionario->foto_funcionario;

            $funcionario->delete();
            $this->excluirImagem($foto);

            return redirect()
                ->route('admin.funcionario.index')
                ->with('sucesso', 'Funcionario excluído com sucesso!');
        } catch (\Throwable $erro) {
            report($erro);

            return redirect()
                ->back()
                ->with('erro', 'Não foi possível excluir o funcionario. Tente novamente.');
        }
    }

    private function salvarImagem($imagem, Funcionario $funcionario, ?string $nome = null): string
    {
        $slug = Str::limit(Str::slug($nome ?? $funcionario->nome_funcionario), 30, '');
        $extensao = strtolower($imagem->getClientOriginalExtension());
        $nomeImagem = $slug . '_' . $funcionario->id_funcionario . '_' . Str::lower(Str::random(6)) . '.' . $extensao;
        $pasta = public_path('pingo-decor/assets/funcionario');

        if (!is_dir($pasta)) {
            mkdir($pasta, 0775, true);
        }

        $imagem->move($pasta, $nomeImagem);

        return 'funcionario/' . $nomeImagem;
    }

    private function excluirImagem(?string $caminhoRelativo): void
    {
        if (!$caminhoRelativo || !str_starts_with($caminhoRelativo, 'funcionario/')) {
            return;
        }

        $this->excluirArquivoFisico(public_path('pingo-decor/assets/funcionario/' . $caminhoRelativo));
    }

    private function excluirArquivoFisico(?string $caminho): void
    {
        if ($caminho && is_file($caminho)) {
            unlink($caminho);
        }
    }
}
