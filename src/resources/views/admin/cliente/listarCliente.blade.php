<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2>Funcionários</h2>
            <p>Gerenciamento de funcionários cadastrados no sistema.</p>
        </div>
        <span class="admin-tag">{{ $listarCliente->count() }} registros</span>
    </div>

    <div class="admin-filter-row">
        <div class="admin-search-fake" aria-label="Busca de funcionário">
            <span aria-hidden="true">&#128269;</span> Buscar funcionário...
        </div>
        <div class="admin-filter-fake" aria-label="Filtros de funcionário">
            <span class="selected">Todos</span><span>Ativos</span><span>Inativos</span>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Status</th>
                    <th scope="col">Atualizado em</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listarCliente as $cliente)
                    <tr>
                        <td>
                            <img class="cell-image" 
                                 src="{{ asset('pingo-decor/assets/' . ltrim((string) data_get($cliente, 'foto_cliente'), '/')) }}"
                                 alt="Foto de {{ data_get($cliente, 'nome_cliente') }}" 
                                 loading="lazy">
                        </td>
                        <td><span class="cell-primary">{{ data_get($cliente, 'nome_cliente') }}</span></td>
                        <td>{{ data_get($cliente, 'email_cliente') }}</td>
                        <td>
                            @php($statusCliente = trim((string) data_get($cliente, 'status_cliente')))
                            <span class="admin-status {{ mb_strtolower($statusCliente) === 'inativo' ? 'inactive' : 'published' }}">
                                {{ $statusCliente }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse(data_get($cliente, 'data_atualizacao_cliente'))->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="admin-actions">
                                <button
                                    type="button"
                                    class="admin-action"
                                    data-admin-modal-open="modalEditarCliente{{ $cliente->id_cliente }}"
                                    aria-haspopup="dialog"
                                >Editar</button>
                                <button
                                    type="button"
                                    class="admin-action admin-action-danger"
                                    data-admin-modal-open="modalExcluirCliente{{ $cliente->id_cliente }}"
                                    aria-haspopup="dialog"
                                >Excluir</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nenhum funcionário cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card-footer">Total de funcionários: {{ $listarCliente->count() }}</div>
</div>

<x-admin.modal id="modalCriarCliente" title="Cadastrar funcionário">
    <form
        class="admin-form"
        id="formCriarCliente"
        action="{{ route('admin.cliente.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="criarNomeCliente">Nome</label>
                <input id="criarNomeCliente" name="nome_cliente" type="text" placeholder="Nome completo" required>
            </div>
            <div class="admin-field">
                <label for="criarEmailCliente">E-mail</label>
                <input id="criarEmailCliente" name="email_cliente" type="email" placeholder="nome@exemplo.com" required>
            </div>
            <div class="admin-field">
                <label for="criarSenhaCliente">Senha</label>
                <input id="criarSenhaCliente" name="senha_cliente" type="password" minlength="6" placeholder="Digite uma senha" required>
            </div>
            <div class="admin-field">
                <label for="criarStatusCliente">Status</label>
                <select id="criarStatusCliente" name="status_cliente" required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarFotoCliente">Foto</label>
                <input id="criarFotoCliente" name="foto_cliente" type="file" accept="image/*" required>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarCliente">Cadastrar funcionário</button>
    </x-slot>
</x-admin.modal>

@foreach ($listarCliente as $cliente)
    <x-admin.modal id="modalEditarCliente{{ $cliente->id_cliente }}" title="Editar funcionário">
        <form
            class="admin-form"
            id="formEditarCliente{{ $cliente->id_cliente }}"
            action="{{ route('admin.cliente.update', $cliente->id_cliente) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="editarNomeCliente{{ $cliente->id_cliente }}">Nome</label>
                    <input
                        id="editarNomeCliente{{ $cliente->id_cliente }}"
                        name="nome_cliente"
                        type="text"
                        value="{{ data_get($cliente, 'nome_cliente') }}"
                        required
                    >
                </div>
                <div class="admin-field">
                    <label for="editarEmailCliente{{ $cliente->id_cliente }}">E-mail</label>
                    <input
                        id="editarEmailCliente{{ $cliente->id_cliente }}"
                        name="email_cliente"
                        type="email"
                        value="{{ data_get($cliente, 'email_cliente') }}"
                        required
                    >
                </div>
                <div class="admin-field">
                    <label for="editarStatusCliente{{ $cliente->id_cliente }}">Status</label>
                    <select id="editarStatusCliente{{ $cliente->id_cliente }}" name="status_cliente" required>
                        <option value="Ativo" @selected(mb_strtolower((string) $cliente->status_cliente) === 'ativo')>Ativo</option>
                        <option value="Inativo" @selected(mb_strtolower((string) $cliente->status_cliente) === 'inativo')>Inativo</option>
                    </select>
                </div>
                <div class="admin-field">
                    <label for="editarFotoCliente{{ $cliente->id_cliente }}">Substituir foto</label>
                    <input
                        id="editarFotoCliente{{ $cliente->id_cliente }}"
                        name="foto_cliente"
                        type="file"
                        accept="image/*"
                    >
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-primary-btn" form="formEditarCliente{{ $cliente->id_cliente }}">Salvar alterações</button>
        </x-slot>
    </x-admin.modal>

    <x-admin.modal
        id="modalExcluirCliente{{ $cliente->id_cliente }}"
        title="Excluir funcionário"
        size="small"
        variant="danger"
    >
        <form
            id="formExcluirCliente{{ $cliente->id_cliente }}"
            action="{{ route('admin.cliente.destroy', $cliente->id_cliente) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>

        <div class="admin-delete-message">
            <span class="admin-delete-icon" aria-hidden="true">!</span>
            <div>
                <p>Tem certeza que deseja excluir <strong>{{ data_get($cliente, 'nome_cliente') }}</strong>?</p>
                <small>Esta ação não poderá ser desfeita.</small>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-danger-btn" form="formExcluirCliente{{ $cliente->id_cliente }}">Excluir funcionário</button>
        </x-slot>
    </x-admin.modal>
@endforeach
