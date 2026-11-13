<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(): View
    {
        $listarCliente = Cliente::orderByDesc('id_cliente')->get();

        return view('admin.cliente.index', compact('listarCliente'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_cliente' => 'required|string|max:50',
            'email_cliente' => 'required|email|max:80|unique:tbl_cliente,email_cliente',
            'telefone_cliente' => 'nullable|string|max:20',
            'senha_cliente' => 'required|string|min:6|max:255',
            'foto_cliente' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status_cliente' => 'required|in:Ativo,Inativo',
        ]);

        $novoArquivo = null;

        try {
            DB::beginTransaction();

            $cliente = Cliente::create([
                'nome_cliente' => $dados['nome_cliente'],
                'email_cliente' => $dados['email_cliente'],
                'telefone_cliente' => $dados['telefone_cliente'] ?? null,
                'senha_cliente' => Hash::make($dados['senha_cliente']),
                'foto_cliente' => 'imagem-indisponivel.svg',
                'status_cliente' => $dados['status_cliente'],
            ]);

            if ($request->hasFile('foto_cliente')) {
                $caminhoRelativo = $this->salvarImagem($request->file('foto_cliente'), $cliente);
                $novoArquivo = public_path('pingo-decor/assets/' . $caminhoRelativo);
                $cliente->update(['foto_cliente' => $caminhoRelativo]);
            }

            DB::commit();

            return redirect()
                ->route('admin.cliente.index')
                ->with('sucesso', 'Cliente cadastrado com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            $this->excluirArquivoFisico($novoArquivo);
            report($erro);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Não foi possível cadastrar o cliente. Tente novamente.');
        }
    }

    public function update(Request $request, int $id)
    {
        $dados = $request->validate([
            'nome_cliente' => 'required|string|max:50',
            'email_cliente' => 'required|email|max:80|unique:tbl_cliente,email_cliente,' . $id . ',id_cliente',
            'telefone_cliente' => 'nullable|string|max:20',
            'foto_cliente' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status_cliente' => 'required|in:Ativo,Inativo',
        ]);

        $cliente = Cliente::findOrFail($id);
        $fotoAntiga = $cliente->foto_cliente;
        $novoArquivo = null;

        try {
            DB::beginTransaction();

            $caminhoFoto = $fotoAntiga;

            if ($request->hasFile('foto_cliente')) {
                $caminhoFoto = $this->salvarImagem($request->file('foto_cliente'), $cliente, $dados['nome_cliente']);
                $novoArquivo = public_path('pingo-decor/assets/cliente' . $caminhoFoto);
            }

            $cliente->update([
                'nome_cliente' => $dados['nome_cliente'],
                'email_cliente' => $dados['email_cliente'],
                'telefone_cliente' => $dados['telefone_cliente'] ?? null,
                'foto_cliente' => $caminhoFoto,
                'status_cliente' => $dados['status_cliente'],
            ]);

            DB::commit();

            if ($caminhoFoto !== $fotoAntiga) {
                $this->excluirImagem($fotoAntiga);
            }

            return redirect()
                ->route('admin.cliente.index')
                ->with('sucesso', 'Cliente atualizado com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            $this->excluirArquivoFisico($novoArquivo);
            report($erro);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Não foi possível atualizar o cliente. Tente novamente.');
        }
    }

    public function destroy(int $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $foto = $cliente->foto_cliente;

            $cliente->delete();
            $this->excluirImagem($foto);

            return redirect()
                ->route('admin.cliente.index')
                ->with('sucesso', 'Cliente excluído com sucesso!');
        } catch (\Throwable $erro) {
            report($erro);

            return redirect()
                ->back()
                ->with('erro', 'Não foi possível excluir o cliente. Tente novamente.');
        }
    }

    private function salvarImagem($imagem, Cliente $cliente, ?string $nome = null): string
    {
        $slug = Str::limit(Str::slug($nome ?? $cliente->nome_cliente), 30, '');
        $extensao = strtolower($imagem->getClientOriginalExtension());
        $nomeImagem = $slug . '_' . $cliente->id_cliente . '_' . Str::lower(Str::random(6)) . '.' . $extensao;
        $pasta = public_path('pingo-decor/assets/cliente');

        if (!is_dir($pasta)) {
            mkdir($pasta, 0775, true);
        }

        $imagem->move($pasta, $nomeImagem);

        return 'cliente/' . $nomeImagem;
    }

    private function excluirImagem(?string $caminhoRelativo): void
    {
        if (!$caminhoRelativo || !str_starts_with($caminhoRelativo, 'cliente/')) {
            return;
        }

        $this->excluirArquivoFisico(public_path('pingo-decor/assets/cliente/' . $caminhoRelativo));
    }

    private function excluirArquivoFisico(?string $caminho): void
    {
        if ($caminho && is_file($caminho)) {
            unlink($caminho);
        }
    }
}
