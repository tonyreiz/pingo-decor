
@php
    $orcamentosAprovados = $listaOrcamento->where('status_orcamento', 'Aprovado');
    $totalAprovados = $orcamentosAprovados->count();
    $totalPendentes = $listaOrcamento->where('status_orcamento', 'Pendente')->count();
    $valorAprovado = $orcamentosAprovados->sum('valor_total_orcamento');
@endphp

<section class="admin-budget-summary" aria-label="Resumo dos orçamentos">
    <article class="admin-budget-stat admin-budget-stat-total">
        <div class="admin-budget-stat-heading">
            <span>Total de orçamentos</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#128196;</span>
        </div>
        <strong>{{ $listaOrcamento->count() }}</strong>
        <small>propostas cadastradas</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-approved">
        <div class="admin-budget-stat-heading">
            <span>Aprovados</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#10003;</span>
        </div>
        <strong>{{ $totalAprovados }}</strong>
        <small>orçamentos confirmados</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-pending">
        <div class="admin-budget-stat-heading">
            <span>Pendentes</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#9201;</span>
        </div>
        <strong>{{ $totalPendentes }}</strong>
        <small>aguardando retorno</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-value">
        <div class="admin-budget-stat-heading">
            <span>Valor aprovado</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">R$</span>
        </div>
        <strong>R$ {{ number_format($valorAprovado, 2, ',', '.') }}</strong>
        <small>soma das propostas aprovadas</small>
    </article>
</section>

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2>Lista de orçamentos</h2>
            <p>Consulte os dados comerciais e atualize o andamento das propostas.</p>
        </div>
        <span class="admin-tag">{{ $listaOrcamento->count() }} registros</span>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table admin-budget-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Orçamento</th>
                    <th>Valor</th>
                    <th>Prazo</th>
                    <th>Status</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listaOrcamento as $orcamento)
                    @php
                        $statusOrcamento = trim((string) $orcamento->status_orcamento);
                        $statusNormalizado = mb_strtolower($statusOrcamento);

                        $statusClass = match ($statusNormalizado) {
                            'aprovado' => 'published',
                            'pendente' => 'draft',
                            'inativo' => 'inactive',
                            default => 'review',
                        };

                        $statusLabel = $statusNormalizado === 'analise'
                            ? 'Análise'
                            : $statusOrcamento;

                        $cliente = $orcamento->cliente;
                    @endphp

                    <tr>
                        <td>
                            <span class="admin-code">
                                #{{ str_pad($orcamento->id_orcamento, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <td>
                            {{ $cliente?->nome_cliente ?? 'Cliente não encontrado' }}
                        </td>

                        <td>
                            <span class="cell-primary">{{ $orcamento->titulo_orcamento }}</span>
                            @if ($orcamento->observacoes_orcamento)
                                <span class="cell-secondary">
                                    {{ \Illuminate\Support\Str::limit($orcamento->observacoes_orcamento, 48) }}
                                </span>
                            @endif
                        </td>

                        <td>
                            <span class="admin-money">
                                R$ {{ number_format($orcamento->valor_total_orcamento, 2, ',', '.') }}
                            </span>
                        </td>

                        <td>{{ $orcamento->prazo_execucao_orcamento }}</td>

                        <td>
                            <span class="admin-status {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>

                        <td>
                            <span class="admin-date">
                                {{ $orcamento->data_criacao_orcamento
                                    ? date('d/m/Y', strtotime($orcamento->data_criacao_orcamento))
                                    : '—' }}
                            </span>
                        </td>

                        <td>
                            <div class="admin-actions">
                                <button
                                    type="button"
                                    class="admin-action"
                                    data-admin-modal-open="modalEditarOrcamento{{ $orcamento->id_orcamento }}"
                                    aria-haspopup="dialog"
                                >Editar</button>

                                <button
                                    type="button"
                                    class="admin-action admin-action-danger"
                                    data-admin-modal-open="modalExcluirOrcamento{{ $orcamento->id_orcamento }}"
                                    aria-haspopup="dialog"
                                >Excluir</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="admin-table-empty">
                                <strong>Nenhum orçamento cadastrado</strong>
                                <small>Use o botão “Novo orçamento” para adicionar a primeira proposta.</small>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card-footer">
        Total de orçamentos: {{ $listaOrcamento->count() }}
    </div>
</div>

<x-admin.modal id="modalNovoOrcamento" title="Novo orçamento" size="large">
    <form
        id="formCriarOrcamento"
        class="admin-form"
        action="{{ route('admin.orcamento.store') }}"
        method="POST"
    >
        @csrf

        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="criarCliente">Cliente</label>
                <select id="criarCliente" name="id_cliente" required>
                    <option value="">Selecione um cliente</option>
                    @foreach ($listaClientes as $cliente)
                        <option value="{{ $cliente->id_cliente }}">
                            {{ $cliente->nome_cliente }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="admin-field">
                <label for="criarTituloOrcamento">Título do orçamento</label>
                <input
                    id="criarTituloOrcamento"
                    type="text"
                    name="titulo_orcamento"
                    maxlength="150"
                    placeholder="Ex.: Quarto infantil"
                    required
                >
            </div>

            <div class="admin-field">
                <label for="criarValorOrcamento">Valor total</label>
                <input
                    id="criarValorOrcamento"
                    type="number"
                    name="valor_total_orcamento"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                    required
                >
            </div>

            <div class="admin-field">
                <label for="criarPrazoOrcamento">Prazo de execução</label>
                <input
                    id="criarPrazoOrcamento"
                    type="text"
                    name="prazo_execucao_orcamento"
                    maxlength="100"
                    placeholder="Ex.: 45 dias"
                    required
                >
            </div>

            <div class="admin-field">
                <label for="criarStatusOrcamento">Status</label>
                <select id="criarStatusOrcamento" name="status_orcamento" required>
                    <option value="Pendente">Pendente</option>
                    <option value="Aprovado">Aprovado</option>
                    <option value="Analise">Análise</option>
                </select>
            </div>

            <div class="admin-field admin-field-full">
                <label for="criarObservacoesOrcamento">Observações</label>
                <textarea
                    id="criarObservacoesOrcamento"
                    name="observacoes_orcamento"
                    rows="4"
                    placeholder="Adicione detalhes importantes sobre a proposta"
                ></textarea>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarOrcamento">
            Salvar orçamento
        </button>
    </x-slot>
</x-admin.modal>

@foreach ($listaOrcamento as $orcamento)
    <x-admin.modal
        id="modalEditarOrcamento{{ $orcamento->id_orcamento }}"
        title="Editar orçamento"
        size="large"
    >
        <form
            id="formEditarOrcamento{{ $orcamento->id_orcamento }}"
            class="admin-form"
            action="{{ route('admin.orcamento.update', $orcamento->id_orcamento) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="editarCliente{{ $orcamento->id_orcamento }}">Cliente</label>
                    <select
                        id="editarCliente{{ $orcamento->id_orcamento }}"
                        name="id_cliente"
                        required
                    >
                        <option value="">Selecione um cliente</option>
                        @foreach ($listaClientes as $cliente)
                            <option
                                value="{{ $cliente->id_cliente }}"
                                @selected((int) $orcamento->id_cliente === (int) $cliente->id_cliente)
                            >
                                {{ $cliente->nome_cliente }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-field">
                    <label for="editarTituloOrcamento{{ $orcamento->id_orcamento }}">Título do orçamento</label>
                    <input
                        id="editarTituloOrcamento{{ $orcamento->id_orcamento }}"
                        type="text"
                        name="titulo_orcamento"
                        maxlength="150"
                        value="{{ $orcamento->titulo_orcamento }}"
                        required
                    >
                </div>

                <div class="admin-field">
                    <label for="editarValorOrcamento{{ $orcamento->id_orcamento }}">Valor total</label>
                    <input
                        id="editarValorOrcamento{{ $orcamento->id_orcamento }}"
                        type="number"
                        name="valor_total_orcamento"
                        step="0.01"
                        min="0"
                        value="{{ $orcamento->valor_total_orcamento }}"
                        required
                    >
                </div>

                <div class="admin-field">
                    <label for="editarPrazoOrcamento{{ $orcamento->id_orcamento }}">Prazo de execução</label>
                    <input
                        id="editarPrazoOrcamento{{ $orcamento->id_orcamento }}"
                        type="text"
                        name="prazo_execucao_orcamento"
                        maxlength="100"
                        value="{{ $orcamento->prazo_execucao_orcamento }}"
                        required
                    >
                </div>

                <div class="admin-field">
                    <label for="editarStatusOrcamento{{ $orcamento->id_orcamento }}">Status</label>
                    <select
                        id="editarStatusOrcamento{{ $orcamento->id_orcamento }}"
                        name="status_orcamento"
                        required
                    >
                        <option value="Pendente" @selected($orcamento->status_orcamento === 'Pendente')>
                            Pendente
                        </option>
                        <option value="Aprovado" @selected($orcamento->status_orcamento === 'Aprovado')>
                            Aprovado
                        </option>
                        <option value="Analise" @selected($orcamento->status_orcamento === 'Analise')>
                            Análise
                        </option>
                    </select>
                </div>

                <div class="admin-field admin-field-full">
                    <label for="editarObservacoesOrcamento{{ $orcamento->id_orcamento }}">Observações</label>
                    <textarea
                        id="editarObservacoesOrcamento{{ $orcamento->id_orcamento }}"
                        name="observacoes_orcamento"
                        rows="4"
                    >{{ $orcamento->observacoes_orcamento }}</textarea>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button
                type="submit"
                class="admin-primary-btn"
                form="formEditarOrcamento{{ $orcamento->id_orcamento }}"
            >Salvar alterações</button>
        </x-slot>
    </x-admin.modal>

    <x-admin.modal
        id="modalExcluirOrcamento{{ $orcamento->id_orcamento }}"
        title="Excluir orçamento"
        size="small"
        variant="danger"
    >
        <form
            id="formExcluirOrcamento{{ $orcamento->id_orcamento }}"
            action="{{ route('admin.orcamento.destroy', $orcamento->id_orcamento) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>

        <div class="admin-delete-message">
            <span class="admin-delete-icon" aria-hidden="true">!</span>
            <div>
                <p>
                    Tem certeza que deseja excluir
                    <strong>{{ $orcamento->titulo_orcamento }}</strong>?
                </p>
                <small>Esta ação não poderá ser desfeita.</small>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button
                type="submit"
                class="admin-danger-btn"
                form="formExcluirOrcamento{{ $orcamento->id_orcamento }}"
            >Excluir orçamento</button>
        </x-slot>
    </x-admin.modal>
@endforeach
