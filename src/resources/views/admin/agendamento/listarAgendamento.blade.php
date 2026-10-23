<div class="admin-card">
    <div class="admin-card-header">
        <h2>Novo agendamento</h2>
    </div>
    <form action="{{ route('admin.agendamento.store') }}" method="POST" class="admin-form">
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="agendamentoCliente">ID do cliente</label>
                <input id="agendamentoCliente" type="number" name="id_cliente" min="1" value="{{ old('id_cliente') }}" required>
            </div>
            <div class="admin-field">
                <label for="agendamentoFuncionario">ID do funcionário</label>
                <input id="agendamentoFuncionario" type="number" name="id_funcionario" min="1" value="{{ old('id_funcionario') }}" required>
            </div>
            <div class="admin-field">
                <label for="agendamentoDia">Dia</label>
                <input id="agendamentoDia" type="text" name="dia_agendamento" maxlength="50" value="{{ old('dia_agendamento') }}" placeholder="Ex.: 30/10/2026" required>
            </div>
            <div class="admin-field">
                <label for="agendamentoHorario">Horário</label>
                <input id="agendamentoHorario" type="number" name="horario_agendamento" min="0" step="0.25" value="{{ old('horario_agendamento') }}" placeholder="Ex.: 14.5" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="agendamentoEndereco">Endereço</label>
                <input id="agendamentoEndereco" type="text" name="endereço_agendamento" maxlength="100" value="{{ old('endereço_agendamento') }}" required>
            </div>
            <div class="admin-field">
                <label for="agendamentoStatus">Status</label>
                <select id="agendamentoStatus" name="status_agendamento" required>
                    <option value="PENDENTE" @selected(old('status_agendamento', 'PENDENTE') === 'PENDENTE')>Pendente</option>
                    <option value="CONFIRMADO" @selected(old('status_agendamento') === 'CONFIRMADO')>Confirmado</option>
                    <option value="CANCELADO" @selected(old('status_agendamento') === 'CANCELADO')>Cancelado</option>
                </select>
            </div>
        </div>
        <button type="submit" class="admin-primary-btn">Salvar agendamento</button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2>Agendamentos cadastrados</h2></div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th><th>Cliente</th><th>Funcionário</th><th>Dia</th>
                    <th>Horário</th><th>Endereço</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listaAgendamento as $agendamento)
                    <tr>
                        <td><span class="admin-code">#{{ $agendamento->id_agendamento }}</span></td>
                        <td>{{ $agendamento->cliente?->nome_cliente ?? 'Cliente não encontrado' }}</td>
                        <td>{{ $agendamento->id_funcionario }}</td>
                        <td>{{ $agendamento->dia_agendamento }}</td>
                        <td>{{ $agendamento->horario_agendamento }}</td>
                        <td>{{ $agendamento->{'endereço_agendamento'} }}</td>
                        <td>{{ $agendamento->status_agendamento }}</td>
                        <td>
                            <div class="admin-row-actions">
                                <button type="button" class="admin-outline-btn" data-admin-modal-open="modalEditarAgendamento{{ $agendamento->id_agendamento }}" aria-haspopup="dialog">Editar</button>
                                <button type="button" class="admin-danger-btn" data-admin-modal-open="modalExcluirAgendamento{{ $agendamento->id_agendamento }}" aria-haspopup="dialog">Excluir</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">Nenhum agendamento cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-card-footer">Total de agendamentos: {{ $listaAgendamento->count() }}</div>
</div>

@foreach ($listaAgendamento as $agendamento)
    <x-admin.modal id="modalEditarAgendamento{{ $agendamento->id_agendamento }}" title="Editar agendamento" size="large">
        <form
            id="formEditarAgendamento{{ $agendamento->id_agendamento }}"
            class="admin-form"
            action="{{ route('admin.agendamento.update', $agendamento->id_agendamento) }}"
            method="POST"
        >
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="editarCliente{{ $agendamento->id_agendamento }}">ID do cliente</label>
                    <input id="editarCliente{{ $agendamento->id_agendamento }}" type="number" name="id_cliente" min="1" value="{{ $agendamento->id_cliente }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarFuncionario{{ $agendamento->id_agendamento }}">ID do funcionário</label>
                    <input id="editarFuncionario{{ $agendamento->id_agendamento }}" type="number" name="id_funcionario" min="1" value="{{ $agendamento->id_funcionario }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarDia{{ $agendamento->id_agendamento }}">Dia</label>
                    <input id="editarDia{{ $agendamento->id_agendamento }}" type="text" name="dia_agendamento" maxlength="50" value="{{ $agendamento->dia_agendamento }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarHorario{{ $agendamento->id_agendamento }}">Horário</label>
                    <input id="editarHorario{{ $agendamento->id_agendamento }}" type="number" name="horario_agendamento" min="0" step="0.25" value="{{ $agendamento->horario_agendamento }}" required>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarEndereco{{ $agendamento->id_agendamento }}">Endereço</label>
                    <input id="editarEndereco{{ $agendamento->id_agendamento }}" type="text" name="endereço_agendamento" maxlength="100" value="{{ $agendamento->{'endereço_agendamento'} }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarStatus{{ $agendamento->id_agendamento }}">Status</label>
                    <select id="editarStatus{{ $agendamento->id_agendamento }}" name="status_agendamento" required>
                        <option value="PENDENTE" @selected($agendamento->status_agendamento === 'PENDENTE')>Pendente</option>
                        <option value="CONFIRMADO" @selected($agendamento->status_agendamento === 'CONFIRMADO')>Confirmado</option>
                        <option value="CANCELADO" @selected($agendamento->status_agendamento === 'CANCELADO')>Cancelado</option>
                    </select>
                </div>
            </div>
        </form>
        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-primary-btn" form="formEditarAgendamento{{ $agendamento->id_agendamento }}">Salvar alterações</button>
        </x-slot>
    </x-admin.modal>

    <x-admin.modal id="modalExcluirAgendamento{{ $agendamento->id_agendamento }}" title="Excluir agendamento" size="small" variant="danger">
        <form
            id="formExcluirAgendamento{{ $agendamento->id_agendamento }}"
            action="{{ route('admin.agendamento.destroy', $agendamento->id_agendamento) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>
        <div class="admin-delete-message">
            <span class="admin-delete-icon" aria-hidden="true">!</span>
            <div>
                <p>Tem certeza que deseja excluir o agendamento <strong>#{{ $agendamento->id_agendamento }}</strong>?</p>
                <small>Esta ação não poderá ser desfeita.</small>
            </div>
        </div>
        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-danger-btn" form="formExcluirAgendamento{{ $agendamento->id_agendamento }}">Excluir agendamento</button>
        </x-slot>
    </x-admin.modal>
@endforeach
