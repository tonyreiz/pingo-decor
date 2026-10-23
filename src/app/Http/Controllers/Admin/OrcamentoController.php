<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrcamentoController extends Controller
{
    public function index()
    {
        $listaOrcamento = Orcamento::with('cliente')
            ->orderByDesc('id_orcamento')
            ->get();

        $listaClientes = Cliente::orderBy('nome_cliente')->get();

        return view('admin.orcamento.index', compact(
            'listaOrcamento',
            'listaClientes'
        ));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_contato' => 'required|integer|exists:tbl_cliente,id_cliente',
            'titulo_orcamento' => 'required|string|max:50',
            'valor_total_orcamento' => 'required|numeric|min:0',
            'prazo_execucao_orcamento' => 'required|string|max:100',
            'observacoes_orcamento' => 'nullable|string',
            'status_orcamento' => 'required|in:Pendente,Aprovado,Analise',
        ]);

        try {
            DB::beginTransaction();

            Orcamento::create([
                'id_contato' => $dados['id_contato'],
                'titulo_orcamento' => $dados['titulo_orcamento'],
                'valor_total_orcamento' => $dados['valor_total_orcamento'],
                'prazo_execucao_orcamento' => $dados['prazo_execucao_orcamento'],
                'observacoes_orcamento' => $dados['observacoes_orcamento'] ?? '',
                'status_orcamento' => $dados['status_orcamento'],
                'data_criacao_orcamento' => now(),
                'data_atualizacao_orcamento' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.orcamento.index')
                ->with('sucesso', 'Orçamento cadastrado com sucesso!');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Erro ao cadastrar orçamento. Verifique os dados e tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'id_contato' => 'required|integer|exists:tbl_cliente,id_cliente',
            'titulo_orcamento' => 'required|string|max:50',
            'valor_total_orcamento' => 'required|numeric|min:0',
            'prazo_execucao_orcamento' => 'required|string|max:100',
            'observacoes_orcamento' => 'nullable|string',
            'status_orcamento' => 'required|in:Pendente,Aprovado,Analise',
        ]);

        try {
            DB::beginTransaction();

            $orcamento = Orcamento::findOrFail($id);

            $orcamento->update([
                'id_contato' => $dados['id_contato'],
                'titulo_orcamento' => $dados['titulo_orcamento'],
                'valor_total_orcamento' => $dados['valor_total_orcamento'],
                'prazo_execucao_orcamento' => $dados['prazo_execucao_orcamento'],
                'observacoes_orcamento' => $dados['observacoes_orcamento'] ?? '',
                'status_orcamento' => $dados['status_orcamento'],
                'data_atualizacao_orcamento' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.orcamento.index')
                ->with('sucesso', 'Orçamento atualizado com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            report($erro);

            return redirect()
                ->back()
                ->withInput()
                ->with('erro', 'Erro ao atualizar orçamento. Verifique os dados e tente novamente.');
        }
    }

    public function status(Request $request, $id)
    {
        $dados = $request->validate([
            'status_orcamento' => 'required|in:Pendente,Aprovado,Analise',
        ]);

        try {
            $orcamento = Orcamento::findOrFail($id);

            $orcamento->update([
                'status_orcamento' => $dados['status_orcamento'],
                'data_atualizacao_orcamento' => now(),
            ]);

            return redirect()
                ->route('admin.orcamento.index')
                ->with('sucesso', 'Status atualizado com sucesso!');
        } catch (\Throwable $erro) {
            report($erro);

            return redirect()
                ->back()
                ->with('erro', 'Erro ao atualizar status.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            Orcamento::findOrFail($id)->delete();

            DB::commit();

            return redirect()
                ->route('admin.orcamento.index')
                ->with('sucesso', 'Orçamento excluído com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            report($erro);

            return redirect()
                ->back()
                ->with('erro', 'Não foi possível excluir o orçamento. Tente novamente.');
        }
    }
}