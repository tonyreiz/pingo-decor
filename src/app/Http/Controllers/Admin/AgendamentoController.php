<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendamentoController extends Controller
{
    public function index()
    {
        $listaAgendamento = Agendamento::with(['cliente', 'funcionario'])
            ->orderByDesc('id_agendamento')
            ->get();
        return view('admin.agendamento.index', compact('listaAgendamento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|integer|exists:tbl_cliente,id_cliente',
            'id_funcionario' => 'required|integer|exists:tbl_funcionario,id_funcionario',
            'dia_agendamento' => 'required|date',
            'horario_agendamento' => 'required',
            'status_agendamento' => 'required|string|max:50',
            'endereco_agendamento' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            Agendamento::create([
                'id_cliente' => $request->id_cliente,
                'id_funcionario' => $request->id_funcionario,
                'dia_agendamento' => $request->dia_agendamento,
                'horario_agendamento' => $request->horario_agendamento,
                'status_agendamento' => $request->status_agendamento,
                'endereco_agendamento' => $request->endereco_agendamento,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.agendamento.index')
                ->with('sucesso', 'Agendamento cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('erro', 'Erro ao cadastrar agendamento: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_cliente' => 'required|integer|exists:tbl_cliente,id_cliente',
            'id_funcionario' => 'required|integer|exists:tbl_funcionario,id_funcionario',
            'dia_agendamento' => 'required|date',
            'horario_agendamento' => 'required',
            'status_agendamento' => 'required|string|max:50',
            'endereco_agendamento' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $agendamento = Agendamento::findOrFail($id);

            $agendamento->update([
                'id_cliente' => $request->id_cliente,
                'id_funcionario' => $request->id_funcionario,
                'dia_agendamento' => $request->dia_agendamento,
                'horario_agendamento' => $request->horario_agendamento,
                'status_agendamento' => $request->status_agendamento,
                'endereco_agendamento' => $request->endereco_agendamento,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.agendamento.index')
                ->with('sucesso', 'Agendamento atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('erro', 'Erro ao atualizar agendamento: ' . $e->getMessage());
        }
    }

    public function status(Request $request, $id)
    {
        $request->validate([
            'status_agendamento' => 'required|string|max:50',
        ]);

        try {
            $agendamento = Agendamento::findOrFail($id);

            $agendamento->update([
                'status_agendamento' => $request->status_agendamento,
            ]);

            return redirect()
                ->route('admin.agendamento.index')
                ->with('sucesso', 'Status do agendamento atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('erro', 'Erro ao atualizar status do agendamento.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            Agendamento::findOrFail($id)->delete();

            DB::commit();

            return redirect()
                ->route('admin.agendamento.index')
                ->with('sucesso', 'Agendamento excluído com sucesso!');
        } catch (\Throwable $erro) {
            DB::rollBack();
            report($erro);

            return redirect()
                ->back()
                ->with('erro', 'Não foi possível excluir o agendamento. Tente novamente.');
        }
    }
}