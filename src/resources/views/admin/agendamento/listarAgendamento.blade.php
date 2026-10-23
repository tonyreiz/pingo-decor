@php
    $totalConfirmados = $listaAgendamento->where('status_agendamento', 'CONFIRMADO')->count();
    $totalPendentes = $listaAgendamento->where('status_agendamento', 'PENDENTE')->count();
    $totalCancelados = $listaAgendamento->where('status_agendamento', 'CANCELADO')->count();
    
@endphp


<section class="admin-budget-summary" aria-label="Resumo dos agendamentos">
    <article class="admin-budget-stat admin-budget-stat-total">
        <div class="admin-budget-stat-heading">
            <span>Total de agendamentos</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#128197;</span>
        </div>
        <strong>{{ $listaAgendamento->count() }}</strong>
        <small>agendamentos cadastrados</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-approved">
        <div class="admin-budget-stat-heading">
            <span>Confirmados</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#10003;</span>
        </div>
        <strong>{{ $totalConfirmados }}</strong>
        <small>agendamentos confirmados</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-pending">
        <div class="admin-budget-stat-heading">
            <span>Pendentes</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#9201;</span>
        </div>
        <strong>{{ $totalPendentes }}</strong>
        <small>aguardando confirmação</small>
    </article>

    
    <article class="admin-budget-stat admin-budget-stat-canceled" style="background-color: #ff9a9a;">
        <div class="admin-budget-stat-heading">
            <span>Cancelados</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#9201;</span>
        </div>
        <strong>{{ $totalCancelados }}</strong>
        <small>aguardando confirmação</small>
    </article>
</section>

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2>Lista de agendamentos</h2>
            <p>Consulte e gerencie os agendamentos cadastrados no sistema.</p>
        </div>
        <span class="admin-tag">{{ $listaAgendamento->count() }} registros</span>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table admin-budget-table">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Funcionário</th>
                    <th scope="col">Dia</th>
                    <th scope="col">Horário</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listaAgendamento as $agendamento)
                    @php
                        $status = trim((string) $agendamento->status_agendamento);
                        $statusClass = match ($status) {
                            'CONFIRMADO' => 'published',
                            'PENDENTE' => 'draft',
                            default => 'review',
                        };
                    @endphp
                    <tr>
                        <td><span class="admin-code">#{{ str_pad($agendamento->id_agendamento, 3, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ $agendamento->cliente?->nome_cliente ?? 'Cliente não encontrado' }}</td>
                        <td>{{ $agendamento->funcionario?->nome_funcionario ?? 'Funcionário não vinculado' }}</td>
                        <td>{{ $agendamento->dia_agendamento }}</td>
                        <td>{{ $agendamento->horario_agendamento }}</td>
                        <td>{{ $agendamento->endereco_agendamento }}</td>
                        <td><span class="admin-status {{ $statusClass }}">{{ $status }}</span></td>
                        <td>
                            <div class="admin-actions">
                                <button type="button" class="admin-action"
                                    data-admin-modal-open="modalEditarAgendamento{{ $agendamento->id_agendamento }}"
                                    aria-haspopup="dialog">Editar</button>
                                <button type="button" class="admin-action admin-action-danger"
                                    data-admin-modal-open="modalExcluirAgendamento{{ $agendamento->id_agendamento }}"
                                    aria-haspopup="dialog">Excluir</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="admin-table-empty">
                                <span aria-hidden="true">&#128197;</span>
                                <strong>Nenhum agendamento cadastrado</strong>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card-footer">Total de agendamentos: {{ $listaAgendamento->count() }}</div>
</div>

<x-admin.modal id="modalNovoAgendamento" title="Novo agendamento" size="large">
    <form id="formCriarAgendamento" class="admin-form"
        action="{{ route('admin.agendamento.store') }}" method="POST">
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="criarCliente">Cliente</label>
                <select id="criarCliente" name="id_cliente" required>
                    <option value="">Selecione um cliente</option>
                    @foreach ($listaClientes as $cliente)
                        <option value="{{ $cliente->id_cliente }}" @selected(old('id_cliente') == $cliente->id_cliente)>
                            {{ $cliente->nome_cliente }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="admin-field">
                <label for="criarFuncionario">Funcionário</label>
                <select id="criarFuncionario" name="id_funcionario" required>
                    <option value="">Selecione um funcionário</option>
                    @foreach ($listaFuncionarios as $funcionario)
                        <option value="{{ $funcionario->id_funcionario }}" @selected(old('id_funcionario') == $funcionario->id_funcionario)>
                            {{ $funcionario->nome_funcionario }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="admin-field">
                <label for="criarDiaAgendamento">Dia</label>
                <input id="criarDiaAgendamento" type="text" name="dia_agendamento" maxlength="50" placeholder="Ex.: 30/10/2026" required>
            </div>
            <div class="admin-field">
                <label for="criarHorarioAgendamento">Horário</label>
                <input id="criarHorarioAgendamento" type="text" name="horario_agendamento" min="0" step="0.25" placeholder="Ex.: 14:50" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarEnderecoAgendamento">Endereço</label>
                <input id="criarEnderecoAgendamento" type="text" name="endereco_agendamento" maxlength="100" required>
            </div>
            <div class="admin-field">
                <label for="criarStatusAgendamento">Status</label>
                <select id="criarStatusAgendamento" name="status_agendamento" required>
                    <option value="PENDENTE">Pendente</option>
                    <option value="CONFIRMADO">Confirmado</option>
                    <option value="CANCELADO">Cancelado</option>
                </select>
            </div>
        </div>
    </form>
    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarAgendamento">Salvar agendamento</button>
    </x-slot>
</x-admin.modal>

@foreach ($listaAgendamento as $agendamento)
    <x-admin.modal id="modalEditarAgendamento{{ $agendamento->id_agendamento }}" title="Editar agendamento" size="large">
        <form id="formEditarAgendamento{{ $agendamento->id_agendamento }}" class="admin-form"
            action="{{ route('admin.agendamento.update', $agendamento->id_agendamento) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="editarCliente{{ $agendamento->id_agendamento }}">Cliente</label>
                    <select id="editarCliente{{ $agendamento->id_agendamento }}" name="id_cliente" required>
                        <option value="">Selecione um cliente</option>
                        @foreach ($listaClientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}" @selected((int) $agendamento->id_cliente === (int) $cliente->id_cliente)>
                                {{ $cliente->nome_cliente }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-field">
                    <label for="editarFuncionario{{ $agendamento->id_agendamento }}">Funcionário</label>
                    <select id="editarFuncionario{{ $agendamento->id_agendamento }}" name="id_funcionario" required>
                        <option value="">Selecione um funcionário</option>
                        @foreach ($listaFuncionarios as $funcionario)
                            <option value="{{ $funcionario->id_funcionario }}" @selected((int) $agendamento->id_funcionario === (int) $funcionario->id_funcionario)>
                                {{ $funcionario->nome_funcionario }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-field">
                    <label for="editarDia{{ $agendamento->id_agendamento }}">Dia</label>
                    <input id="editarDia{{ $agendamento->id_agendamento }}" type="text" name="dia_agendamento" maxlength="50" value="{{ $agendamento->dia_agendamento }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarHorario{{ $agendamento->id_agendamento }}">Horário</label>
                    <input id="editarHorario{{ $agendamento->id_agendamento }}" type="text" name="horario_agendamento" min="0" step="0.25" value="{{ $agendamento->horario_agendamento }}" required>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarEndereco{{ $agendamento->id_agendamento }}">Endereço</label>
                    <input id="editarEndereco{{ $agendamento->id_agendamento }}" type="text" name="endereco_agendamento" maxlength="100" value="{{ $agendamento->endereco_agendamento }}" required>
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
        <form id="formExcluirAgendamento{{ $agendamento->id_agendamento }}"
            action="{{ route('admin.agendamento.destroy', $agendamento->id_agendamento) }}" method="POST">
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
