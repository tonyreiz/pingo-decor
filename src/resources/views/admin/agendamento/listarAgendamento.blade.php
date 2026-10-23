<<<<<<< HEAD
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
=======
@php
    $agendamentosAprovados = $listaAgendamento->where('status_agendamento', 'Aprovado');
    $totalAprovados = $agendamentosAprovados->count();
    $totalPendentes = $listaAgendamento->where('status_agendamento', 'Pendente')->count();
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

            <span>Concluídos</span>

            <span class="admin-budget-stat-icon" aria-hidden="true">&#10003;</span>
        </div>
        <strong>{{ $totalAprovados }}</strong>
        <small>agendamentos concluídos</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-pending">
        <div class="admin-budget-stat-heading">
            <span>Pendentes</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#9201;</span>
        </div>
        <strong>{{ $totalPendentes }}</strong>
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

    <div class="admin-filter-row">
        <div class="admin-search-fake" aria-label="Busca de agendamentos">
            <span aria-hidden="true">&#128269;</span> Buscar agendamento...
        </div>
        <div class="admin-filter-fake" aria-label="Filtros de agendamentos">
            <span class="selected">Todos</span>
            <span>Aprovados</span>
            <span>Pendentes</span>
            <span>Análise</span>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table admin-budget-table">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Funcionário</th>
                    <th scope="col">Data / Horário</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Status</th>
                    <th scope="col">Criado em</th>
                    <th scope="col">Ações</th>
>>>>>>> origin/main
                </tr>
            </thead>
            <tbody>
                @forelse ($listaAgendamento as $agendamento)
<<<<<<< HEAD
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
=======
                    @php
                        $statusAgendamento = trim((string) $agendamento->status_agendamento);
                        $statusNormalizado = mb_strtolower($statusAgendamento);
                        $statusClass = match ($statusNormalizado) {
                            'aprovado' => 'published',
                            'pendente' => 'draft',
                            default => 'review',
                        };
                        $statusLabel = $statusNormalizado === 'analise' ? 'Análise' : $statusAgendamento;
                        $cliente = $agendamento->cliente;
                        $funcionario = $agendamento->funcionario;
                    @endphp
                    <tr>
                        <td><span class="admin-code">#{{ str_pad($agendamento->id_agendamento, 3, '0', STR_PAD_LEFT) }}</span></td>
                        <td><span class="admin-code">{{ $cliente?->nome_cliente ?? 'Cliente não encontrado' }}</span></td>
                        <td><span class="cell-primary">{{ $funcionario?->nome_funcionario ?? 'Funcionário não vinculado' }}</span></td>
                        <td>
                            <span class="cell-primary">{{ date('d/m/Y', strtotime($agendamento->dia_agendamento)) }}</span>
                            <span class="cell-secondary">{{ $agendamento->horario_agendamento }}</span>
                        </td>
                        <td>{{ $agendamento->endereco_agendamento }}</td>
                        <td><span class="admin-status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                        <td><span class="admin-date">{{ date('d/m/Y', strtotime($agendamento->data_criacao_agendamento)) }}</span></td>
                        <td>
                            <div class="admin-actions">
                                <button
                                    type="button"
                                    class="admin-action"
                                    data-admin-modal-open="modalEditarAgendamento{{ $agendamento->id_agendamento }}"
                                    aria-haspopup="dialog"
                                >Editar</button>
                                <button
                                    type="button"
                                    class="admin-action admin-action-danger"
                                    data-admin-modal-open="modalExcluirAgendamento{{ $agendamento->id_agendamento }}"
                                    aria-haspopup="dialog"
                                >Excluir</button>
>>>>>>> origin/main
                            </div>
                        </td>
                    </tr>
                @empty
<<<<<<< HEAD
                    <tr><td colspan="8">Nenhum agendamento cadastrado.</td></tr>
=======
                    <tr>
                        <td colspan="8">
                            <div class="admin-table-empty">
                                <span aria-hidden="true">&#128197;</span>
                                <strong>Nenhum agendamento cadastrado</strong>
                                <small>Use o botão “Novo agendamento” para adicionar o primeiro registro.</small>
                            </div>
                        </td>
                    </tr>
>>>>>>> origin/main
                @endforelse
            </tbody>
        </table>
    </div>
<<<<<<< HEAD
    <div class="admin-card-footer">Total de agendamentos: {{ $listaAgendamento->count() }}</div>
</div>

=======

    <div class="admin-card-footer">Total de agendamentos: {{ $listaAgendamento->count() }}</div>
</div>

<x-admin.modal id="modalNovoAgendamento" title="Novo agendamento" size="large">
    <form
        id="formCriarAgendamento"
        class="admin-form"
        action="{{ route('admin.agendamento.store') }}"
        method="POST"
    >
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="criarCliente">ID do cliente</label>
                <input id="criarCliente" type="number" name="id_cliente" min="1" required>
            </div>
            <div class="admin-field">
                <label for="criarFuncionario">ID do funcionário</label>
                <input id="criarFuncionario" type="number" name="id_funcionario" min="1" required>
            </div>
            <div class="admin-field">
                <label for="criarDiaAgendamento">Dia do agendamento</label>
                <input id="criarDiaAgendamento" type="date" name="dia_agendamento" required>
            </div>
            <div class="admin-field">
                <label for="criarHorarioAgendamento">Horário</label>
                <input id="criarHorarioAgendamento" type="time" name="horario_agendamento" required>
            </div>
            <div class="admin-field">
                <label for="criarStatusAgendamento">Status</label>
                <select id="criarStatusAgendamento" name="status_agendamento" required>
                    <option value="Pendente">Pendente</option>
                    <option value="Aprovado">Aprovado</option>
                    <option value="Analise">Análise</option>
                </select>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarEnderecoAgendamento">Endereço do agendamento</label>
                <input id="criarEnderecoAgendamento" type="text" name="endereco_agendamento" placeholder="Ex.: Rua Exemplo, 123" required>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarAgendamento">Salvar agendamento</button>
    </x-slot>
</x-admin.modal>

>>>>>>> origin/main
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
<<<<<<< HEAD
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
=======
                    <label for="editarDiaAgendamento{{ $agendamento->id_agendamento }}">Dia do agendamento</label>
                    <input id="editarDiaAgendamento{{ $agendamento->id_agendamento }}" type="date" name="dia_agendamento" value="{{ $agendamento->dia_agendamento }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarHorarioAgendamento{{ $agendamento->id_agendamento }}">Horário</label>
                    <input id="editarHorarioAgendamento{{ $agendamento->id_agendamento }}" type="time" name="horario_agendamento" value="{{ $agendamento->horario_agendamento }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarStatusAgendamento{{ $agendamento->id_agendamento }}">Status</label>
                    <select id="editarStatusAgendamento{{ $agendamento->id_agendamento }}" name="status_agendamento" required>
                        <option value="Pendente" @selected($agendamento->status_agendamento === 'Pendente')>Pendente</option>
                        <option value="Aprovado" @selected($agendamento->status_agendamento === 'Aprovado')>Aprovado</option>
                        <option value="Analise" @selected($agendamento->status_agendamento === 'Analise')>Análise</option>
                    </select>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarEnderecoAgendamento{{ $agendamento->id_agendamento }}">Endereço</label>
                    <input id="editarEnderecoAgendamento{{ $agendamento->id_agendamento }}" type="text" name="endereco_agendamento" value="{{ $agendamento->endereco_agendamento }}" required>
                </div>
            </div>
        </form>

>>>>>>> origin/main
        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-primary-btn" form="formEditarAgendamento{{ $agendamento->id_agendamento }}">Salvar alterações</button>
        </x-slot>
    </x-admin.modal>

<<<<<<< HEAD
    <x-admin.modal id="modalExcluirAgendamento{{ $agendamento->id_agendamento }}" title="Excluir agendamento" size="small" variant="danger">
=======
    <x-admin.modal
        id="modalExcluirAgendamento{{ $agendamento->id_agendamento }}"
        title="Excluir agendamento"
        size="small"
        variant="danger"
    >
>>>>>>> origin/main
        <form
            id="formExcluirAgendamento{{ $agendamento->id_agendamento }}"
            action="{{ route('admin.agendamento.destroy', $agendamento->id_agendamento) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>
<<<<<<< HEAD
=======

>>>>>>> origin/main
        <div class="admin-delete-message">
            <span class="admin-delete-icon" aria-hidden="true">!</span>
            <div>
                <p>Tem certeza que deseja excluir o agendamento <strong>#{{ $agendamento->id_agendamento }}</strong>?</p>
                <small>Esta ação não poderá ser desfeita.</small>
            </div>
        </div>
<<<<<<< HEAD
=======

>>>>>>> origin/main
        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-danger-btn" form="formExcluirAgendamento{{ $agendamento->id_agendamento }}">Excluir agendamento</button>
        </x-slot>
    </x-admin.modal>
<<<<<<< HEAD
@endforeach
=======
@endforeach
>>>>>>> origin/main
