<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2>Mensagens / Contatos</h2>
            <p>Lista de contatos registrados no sistema.</p>
        </div>
        <span class="admin-tag">{{ $listarContato->count() }} registros</span>
    </div>

    <div class="admin-filter-row">
        <div class="admin-search-fake" aria-label="Busca de contatos">
            <span aria-hidden="true">&#128269;</span> Buscar contato...
        </div>
        <div class="admin-filter-fake" aria-label="Filtros de contatos">
            <span class="selected">Todos</span>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Estado Cívil</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Cidade/Bairro</th>
                    <th scope="col">Profissão</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listarContato as $contato)
                    <tr>
                        <td><span class="cell-primary">{{ data_get($contato, 'nome_contato') }}</span></td>
                        <td>{{ data_get($contato, 'nome_companheiro_contato') }}</td>
                        <td>{{ data_get($contato, 'email_contato') }}</td>
                        <td>{{ data_get($contato, 'telefone_contato') }}</td>
                        <td>{{ data_get($contato, 'cidade_bairro_contato') }}</td>
                        <td>{{ data_get($contato, 'profissao_contato') }}</td>
                        <td>
                            <div class="admin-actions">
                                <button
                                    type="button"
                                    class="admin-action"
                                    data-admin-modal-open="modalEditarContato{{ $contato->id_contato }}"
                                    aria-haspopup="dialog"
                                >Editar</button>
                                <button
                                    type="button"
                                    class="admin-action admin-action-danger"
                                    data-admin-modal-open="modalExcluirContato{{ $contato->id_contato }}"
                                    aria-haspopup="dialog"
                                >Excluir</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Nenhum contato encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card-footer">Total de contatos: {{ $listarContato->count() }}</div>
</div>

<x-admin.modal id="modalCriarContato" title="Criar contato" size="large">
    <form
        class="admin-form"
        id="formCriarContato"
        action="{{ route('admin.contato.store') }}"
        method="POST"
    >
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="criarNomeContato">Nome</label>
                <input id="criarNomeContato" name="nome_contato" type="text" placeholder="Nome completo" required>
            </div>
            <div class="admin-field">
                <label for="criarCompanheiroContato">Companheiro(a)</label>
                <input id="criarCompanheiroContato" name="nome_companheiro_contato" type="text" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarCriancasContato">Nome e idade das crianças</label>
                <input id="criarCriancasContato" name="nome_idade_criancas_contato" type="text" required>
            </div>
            <div class="admin-field">
                <label for="criarEmailContato">E-mail</label>
                <input id="criarEmailContato" name="email_contato" type="email" placeholder="nome@exemplo.com" required>
            </div>
            <div class="admin-field">
                <label for="criarTelefoneContato">Telefone</label>
                <input id="criarTelefoneContato" name="telefone_contato" type="tel" placeholder="(00) 00000-0000" required>
            </div>
            <div class="admin-field">
                <label for="criarCidadeContato">Cidade / Bairro</label>
                <input id="criarCidadeContato" name="cidade_bairro_contato" type="text" required>
            </div>
            <div class="admin-field">
                <label for="criarProfissaoContato">Profissão</label>
                <input id="criarProfissaoContato" name="profissao_contato" type="text" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarOrigemContato">Como conheceu a Pingo Decor?</label>
                <input id="criarOrigemContato" name="origem_contato" type="text" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarAjudaContato">Como podemos ajudar?</label>
                <input id="criarAjudaContato" name="ajuda_contato" type="text" required>
            </div>
            <div class="admin-field">
                <label for="criarMetragemContato">Metragem</label>
                <input id="criarMetragemContato" name="metragem_contato" type="text" required>
            </div>
            <div class="admin-field">
                <label for="criarAmbientesContato">Quantidade de ambientes</label>
                <input id="criarAmbientesContato" name="quantidades_ambientes_contato" type="text" required>
            </div>
            <div class="admin-field">
                <label for="criarGestacaoContato">Trimestre da gestação</label>
                <input id="criarGestacaoContato" name="trimestre_gestacao_contato" type="text" required>
            </div>
            <div class="admin-field">
                <label for="criarPrazoContato">Prazo desejado</label>
                <input id="criarPrazoContato" name="prazo_contato" type="text" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarDetalhesContato">Detalhes</label>
                <textarea id="criarDetalhesContato" name="detalhes_contato" rows="3" required></textarea>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarContato">Criar contato</button>
    </x-slot>
</x-admin.modal>

@foreach ($listarContato as $contato)
    <x-admin.modal id="modalEditarContato{{ $contato->id_contato }}" title="Editar contato" size="large">
        <form
            class="admin-form"
            id="formEditarContato{{ $contato->id_contato }}"
            action="{{ route('admin.contato.update', $contato->id_contato) }}"
            method="POST"
        >
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="editarNomeContato{{ $contato->id_contato }}">Nome</label>
                    <input id="editarNomeContato{{ $contato->id_contato }}" name="nome_contato" type="text" value="{{ data_get($contato, 'nome_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarCompanheiroContato{{ $contato->id_contato }}">Companheiro(a)</label>
                    <input id="editarCompanheiroContato{{ $contato->id_contato }}" name="nome_companheiro_contato" type="text" value="{{ data_get($contato, 'nome_companheiro_contato') }}" required>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarCriancasContato{{ $contato->id_contato }}">Nome e idade das crianças</label>
                    <input id="editarCriancasContato{{ $contato->id_contato }}" name="nome_idade_criancas_contato" type="text" value="{{ data_get($contato, 'nome_idade_criancas_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarEmailContato{{ $contato->id_contato }}">E-mail</label>
                    <input id="editarEmailContato{{ $contato->id_contato }}" name="email_contato" type="email" value="{{ data_get($contato, 'email_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarTelefoneContato{{ $contato->id_contato }}">Telefone</label>
                    <input id="editarTelefoneContato{{ $contato->id_contato }}" name="telefone_contato" type="tel" value="{{ data_get($contato, 'telefone_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarCidadeContato{{ $contato->id_contato }}">Cidade / Bairro</label>
                    <input id="editarCidadeContato{{ $contato->id_contato }}" name="cidade_bairro_contato" type="text" value="{{ data_get($contato, 'cidade_bairro_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarProfissaoContato{{ $contato->id_contato }}">Profissão</label>
                    <input id="editarProfissaoContato{{ $contato->id_contato }}" name="profissao_contato" type="text" value="{{ data_get($contato, 'profissao_contato') }}" required>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarOrigemContato{{ $contato->id_contato }}">Como conheceu a Pingo Decor?</label>
                    <input id="editarOrigemContato{{ $contato->id_contato }}" name="origem_contato" type="text" value="{{ data_get($contato, 'origem_contato') }}" required>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarAjudaContato{{ $contato->id_contato }}">Como podemos ajudar?</label>
                    <input id="editarAjudaContato{{ $contato->id_contato }}" name="ajuda_contato" type="text" value="{{ data_get($contato, 'ajuda_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarMetragemContato{{ $contato->id_contato }}">Metragem</label>
                    <input id="editarMetragemContato{{ $contato->id_contato }}" name="metragem_contato" type="text" value="{{ data_get($contato, 'metragem_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarAmbientesContato{{ $contato->id_contato }}">Quantidade de ambientes</label>
                    <input id="editarAmbientesContato{{ $contato->id_contato }}" name="quantidades_ambientes_contato" type="text" value="{{ data_get($contato, 'quantidades_ambientes_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarGestacaoContato{{ $contato->id_contato }}">Trimestre da gestação</label>
                    <input id="editarGestacaoContato{{ $contato->id_contato }}" name="trimestre_gestacao_contato" type="text" value="{{ data_get($contato, 'trimestre_gestacao_contato') }}" required>
                </div>
                <div class="admin-field">
                    <label for="editarPrazoContato{{ $contato->id_contato }}">Prazo desejado</label>
                    <input id="editarPrazoContato{{ $contato->id_contato }}" name="prazo_contato" type="text" value="{{ data_get($contato, 'prazo_contato') }}" required>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarDetalhesContato{{ $contato->id_contato }}">Detalhes</label>
                    <textarea id="editarDetalhesContato{{ $contato->id_contato }}" name="detalhes_contato" rows="3" required>{{ data_get($contato, 'detalhes_contato') }}</textarea>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-primary-btn" form="formEditarContato{{ $contato->id_contato }}">Salvar alterações</button>
        </x-slot>
    </x-admin.modal>

    <x-admin.modal
        id="modalExcluirContato{{ $contato->id_contato }}"
        title="Excluir contato"
        size="small"
        variant="danger"
    >
        <form
            id="formExcluirContato{{ $contato->id_contato }}"
            action="{{ route('admin.contato.destroy', $contato->id_contato) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>

        <div class="admin-delete-message">
            <span class="admin-delete-icon" aria-hidden="true">!</span>
            <div>
                <p>Tem certeza que deseja excluir o contato de <strong>{{ data_get($contato, 'nome_contato') }}</strong>?</p>
                <small>Esta ação não poderá ser desfeita.</small>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-danger-btn" form="formExcluirContato{{ $contato->id_contato }}">Excluir contato</button>
        </x-slot>
    </x-admin.modal>
@endforeach
