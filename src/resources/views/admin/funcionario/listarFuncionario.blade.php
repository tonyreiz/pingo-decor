<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2>Funcionários</h2>
            <p>Gerenciamento de funcionários cadastrados no sistema.</p>
        </div>
        <span class="admin-tag">{{ $listarFuncionario->count() }} registros</span>
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
                    <th scope="col">Código</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Senha</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listarFuncionario as $lista)
                <tr>
                    <td>{{ data_get($lista, 'id_funcionario') }}</td>
                    <td>
                        <img class="cell-image"
                            src="{{ asset('pingo-decor/assets/' . ltrim((string) data_get($lista, 'foto_funcionario'), '/')) }}"
                            alt="Foto de {{ data_get($lista, 'nome_funcionario') }}"
                            loading="lazy">
                    </td>
                    <td><span class="cell-primary">{{ data_get($lista, 'nome_funcionario') }}</span></td>
                    <td>{{ data_get($lista, 'email_funcionario') }}</td>
                    <td>{{ data_get($lista, 'senha_funcionario') }}</td>
                    <td>{{ data_get($lista, 'telefone_funcionario') }}</td>
                    <td>{{ data_get($lista, 'cargo_funcionario') }}</td>
                    <td>
                        @php($statusFuncionario = trim((string) data_get($lista, 'status_funcionario')))
                        <span class="admin-status {{ mb_strtolower($statusFuncionario) === 'inativo' ? 'inactive' : 'published' }}">
                            {{ $statusFuncionario }}
                        </span>
                    </td>
                    <td>
                        <div class="admin-actions">
                            <button
                                type="button"
                                class="admin-action"
                                data-admin-modal-open="modalEditarFuncionario{{ $lista->id_funcionario }}"
                                aria-haspopup="dialog">Editar</button>
                            <button
                                type="button"
                                class="admin-action admin-action-danger"
                                data-admin-modal-open="modalExcluirFuncionario{{ $lista->id_funcionario }}"
                                aria-haspopup="dialog">Excluir</button>
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

    <div class="admin-card-footer">Total de funcionários: {{ $listarFuncionario->count() }}</div>
</div>

<x-admin.modal id="modalCriarFuncionario" title="Cadastrar funcionário">
    <form
        class="admin-form"
        id="formCriarFuncionario"
        action="{{ route('admin.funcionario.store') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="criarNomeFuncionario">Nome</label>
                <input id="criarNomeFuncionario" name="nome_funcionario" type="text" placeholder="Nome completo" required>
            </div>
            <div class="admin-field">
                <label for="criarEmailFuncionario">E-mail</label>
                <input id="criarEmailFuncionario" name="email_funcionario" type="email" placeholder="nome@exemplo.com" required>
            </div>
            <div class="admin-field">
                <label for="criarSenhaFuncionario">Senha</label>
                <input id="criarSenhaFuncionario" name="senha_funcionario" type="password" minlength="6" placeholder="Digite uma senha" required>
            </div>

            <div class="admin-field">
                <label for="criarTelefoneFuncionario">Telefone</label>
                <input id="criarTelefoneFuncionario" name="telefone_funcionario" type="text" minlength="13" placeholder="Digite um telefone" required>
            </div>

            <div class="admin-field">
                <label for="criarCargoFuncionario">Cargo</label>
                <input id="criarCargoFuncionario" name="cargo_funcionario" type="text" minlength="6" placeholder="Digite um cargo" required>
            </div>

            <div class="admin-field">
                <label for="criarStatusFuncionario">Status</label>
                <select id="criarStatusFuncionario" name="status_funcionario" required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarFotoFuncionario">Foto</label>
                <input id="criarFotoFuncionario" name="foto_funcionario" type="file" accept="image/*" required>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarFuncionario">Cadastrar funcionário</button>
    </x-slot>
</x-admin.modal>

@foreach ($listarFuncionario as $lista)
<x-admin.modal id="modalEditarFuncionario{{ $lista->id_funcionario }}" title="Editar funcionário">
    <form
        class="admin-form"
        id="formEditarFuncionario{{ $lista->id_funcionario }}"
        action="{{ route('admin.funcionario.update', $lista->id_funcionario) }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="editarNomeFuncionario{{ $lista->id_funcionario }}">Nome</label>
                <input
                    id="editarNomeFuncionario{{ $lista->id_funcionario }}"
                    name="nome_funcionario"
                    type="text"
                    value="{{ data_get($lista, 'nome_funcionario') }}"
                    required>
            </div>
            <div class="admin-field">
                <label for="editarEmailFuncionario{{ $lista->id_funcionario }}">E-mail</label>
                <input
                    id="editarEmailFuncionario{{ $lista->id_funcionario }}"
                    name="email_funcionario"
                    type="email"
                    value="{{ data_get($lista, 'email_funcionario') }}"
                    required>
            </div>

            <div class="admin-field">
                <label for="editarSenhaFuncionario{{ $lista->id_funcionario }}">Senha</label>
                <input
                    id="editarSenhaFuncionario{{ $lista->id_funcionario }}"
                    name="senha_funcionario"
                    type="password"
                    minlength="6"
                    placeholder="Deixe em branco para manter a senha atual">
            </div>

            <div class="admin-field">
                <label for="editarTelefoneFuncionario{{ $lista->id_funcionario }}">Telefone</label>
                <input
                    id="editarTelefoneFuncionario{{ $lista->id_funcionario }}"
                    name="telefone_funcionario"
                    type="telefone"
                    value="{{ data_get($lista, 'telefone_funcionario') }}"
                    required>
            </div>

            <div class="admin-field">
                <label for="editarCargoFuncionario{{ $lista->id_funcionario }}">Cargo</label>
                <input
                    id="editarCargoFuncionario{{ $lista->id_funcionario }}"
                    name="cargo_funcionario"
                    type="text"
                    value="{{ data_get($lista, 'cargo_funcionario') }}"
                    required>
            </div>

            <div class="admin-field">
                <label for="editarStatusFuncionario{{ $lista->id_funcionario }}">Status</label>
                <select id="editarStatusFuncionario{{ $lista->id_funcionario }}" name="status_funcionario" required>
                    <option value="Ativo" @selected(mb_strtolower((string) $lista->status_funcionario) === 'ativo')>Ativo</option>
                    <option value="Inativo" @selected(mb_strtolower((string) $lista->status_funcionario) === 'inativo')>Inativo</option>
                </select>
            </div>
            <div class="admin-field">
                <label for="editarFotoFuncionario{{ $lista->id_funcionario }}">Substituir foto</label>
                <input
                    id="editarFotoFuncionario{{ $lista->id_funcionario }}"
                    name="foto_funcionario"
                    type="file"
                    accept="image/*">
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formEditarFuncionario{{ $lista->id_funcionario }}">Salvar alterações</button>
    </x-slot>
</x-admin.modal>

<x-admin.modal
    id="modalExcluirFuncionario{{ $lista->id_funcionario }}"
    title="Excluir funcionário"
    size="small"
    variant="danger">
    <form
        id="formExcluirFuncionario{{ $lista->id_funcionario }}"
        action="{{ route('admin.funcionario.destroy', $lista->id_funcionario) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </form>

    <div class="admin-delete-message">
        <span class="admin-delete-icon" aria-hidden="true">!</span>
        <div>
            <p>Tem certeza que deseja excluir <strong>{{ data_get($lista, 'nome_funcionario') }}</strong>?</p>
            <small>Esta ação não poderá ser desfeita.</small>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-danger-btn" form="formExcluirFuncionario{{ $lista->id_funcionario }}">Excluir funcionário</button>
    </x-slot>
</x-admin.modal>
@endforeach
