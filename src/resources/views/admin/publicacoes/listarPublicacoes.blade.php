<div class="admin-card">

    <div class="admin-card-header">
        <div>
            <h2>Publicações</h2>
            <p>Lista de publicações cadastradas no sistema.</p>
        </div>

        <span class="admin-tag">
            {{ $listarPublicacoes->count() }} registros
        </span>
    </div>

    <div class="admin-filter-row">

        <div class="admin-search-fake">
            <span aria-hidden="true">🔍</span>
            Buscar publicação...
        </div>

        <div class="admin-filter-fake">
            <span class="selected">Todas</span>
        </div>

    </div>

    <div class="admin-table-wrap">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Link</th>
                    <th>Data Publicação</th>
                    <th>Atualizado</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($listarPublicacoes as $publicacao)

                    <tr>

                        <td>
                            <img
                                src="{{ asset('pingo-decor/assets/publicacao/' . ltrim($publicacao->imagem_publicacoes, '/')) }}"
                                alt="{{ $publicacao->titulo_publicacoes }}"
                                class="cell-image"
                                loading="lazy"
                            >
                        </td>

                        <td>
                            <span class="cell-primary">
                                {{ $publicacao->titulo_publicacoes }}
                            </span>
                        </td>

                        <td>
                            {{ Str::limit($publicacao->descricao_publicacoes, 100) }}
                        </td>

                        <td>
                            <a
                                href="{{ $publicacao->link_publicacoes }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="admin-link"
                            >
                                Abrir
                            </a>
                        </td>

                        <td>
                            {{ date('d/m/Y H:i', strtotime($publicacao->data_publicacoes)) }}
                        </td>

                        <td>
                            {{ date('d/m/Y H:i', strtotime($publicacao->data_atualizacao_publicacoes)) }}
                        </td>

                        <td>
                            <div class="admin-actions">
                                <button
                                    type="button"
                                    class="admin-action"
                                    data-admin-modal-open="modalEditarPublicacao{{ $publicacao->id_publicacoes }}"
                                    aria-haspopup="dialog"
                                >Editar</button>
                                <button
                                    type="button"
                                    class="admin-action admin-action-danger"
                                    data-admin-modal-open="modalExcluirPublicacao{{ $publicacao->id_publicacoes }}"
                                    aria-haspopup="dialog"
                                >Excluir</button>
                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            Nenhuma publicação cadastrada.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<x-admin.modal id="modalCriarPublicacao" title="Criar publicação" size="large">
    <form
        class="admin-form"
        id="formCriarPublicacao"
        action="{{ route('admin.publicacoes.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field admin-field-full">
                <label for="criarTituloPublicacao">Título</label>
                <input id="criarTituloPublicacao" name="titulo_publicacoes" type="text" placeholder="Título da publicação" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarDescricaoPublicacao">Descrição</label>
                <textarea id="criarDescricaoPublicacao" name="descricao_publicacoes" rows="4" placeholder="Descrição da publicação" required></textarea>
            </div>
            <div class="admin-field">
                <label for="criarLinkPublicacao">Link</label>
                <input id="criarLinkPublicacao" name="link_publicacoes" type="url" placeholder="https://" required>
            </div>
            <div class="admin-field">
                <label for="criarDataPublicacao">Data de publicação</label>
                <input id="criarDataPublicacao" name="data_publicacoes" type="datetime-local" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarImagemPublicacao">Imagem</label>
                <input id="criarImagemPublicacao" name="imagem_publicacoes" type="file" accept="image/*" required>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarPublicacao">Criar publicação</button>
    </x-slot>
</x-admin.modal>

@foreach ($listarPublicacoes as $publicacao)
    <x-admin.modal id="modalEditarPublicacao{{ $publicacao->id_publicacoes }}" title="Editar publicação" size="large">
        <form
            class="admin-form"
            id="formEditarPublicacao{{ $publicacao->id_publicacoes }}"
            action="{{ route('admin.publicacoes.update', $publicacao->id_publicacoes) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="admin-form-grid">
                <div class="admin-field admin-field-full">
                    <label for="editarTituloPublicacao{{ $publicacao->id_publicacoes }}">Título</label>
                    <input
                        id="editarTituloPublicacao{{ $publicacao->id_publicacoes }}"
                        name="titulo_publicacoes"
                        type="text"
                        value="{{ $publicacao->titulo_publicacoes }}"
                        required
                    >
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarDescricaoPublicacao{{ $publicacao->id_publicacoes }}">Descrição</label>
                    <textarea id="editarDescricaoPublicacao{{ $publicacao->id_publicacoes }}" name="descricao_publicacoes" rows="4" required>{{ $publicacao->descricao_publicacoes }}</textarea>
                </div>
                <div class="admin-field">
                    <label for="editarLinkPublicacao{{ $publicacao->id_publicacoes }}">Link</label>
                    <input
                        id="editarLinkPublicacao{{ $publicacao->id_publicacoes }}"
                        name="link_publicacoes"
                        type="url"
                        value="{{ $publicacao->link_publicacoes }}"
                        required
                    >
                </div>
                <div class="admin-field">
                    <label for="editarDataPublicacao{{ $publicacao->id_publicacoes }}">Data de publicação</label>
                    <input
                        id="editarDataPublicacao{{ $publicacao->id_publicacoes }}"
                        name="data_publicacoes"
                        type="datetime-local"
                        value="{{ date('Y-m-d\TH:i', strtotime($publicacao->data_publicacoes)) }}"
                        required
                    >
                </div>
                <div class="admin-field admin-field-full">
                    <label for="editarImagemPublicacao{{ $publicacao->id_publicacoes }}">Substituir imagem</label>
                    <input
                        id="editarImagemPublicacao{{ $publicacao->id_publicacoes }}"
                        name="imagem_publicacoes"
                        type="file"
                        accept="image/*"
                    >
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-primary-btn" form="formEditarPublicacao{{ $publicacao->id_publicacoes }}">Salvar alterações</button>
        </x-slot>
    </x-admin.modal>

    <x-admin.modal
        id="modalExcluirPublicacao{{ $publicacao->id_publicacoes }}"
        title="Excluir publicação"
        size="small"
        variant="danger"
    >
        <form
            id="formExcluirPublicacao{{ $publicacao->id_publicacoes }}"
            action="{{ route('admin.publicacoes.destroy', $publicacao->id_publicacoes) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>

        <div class="admin-delete-message">
            <span class="admin-delete-icon" aria-hidden="true">!</span>
            <div>
                <p>Tem certeza que deseja excluir <strong>{{ $publicacao->titulo_publicacoes }}</strong>?</p>
                <small>Esta ação não poderá ser desfeita.</small>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-danger-btn" form="formExcluirPublicacao{{ $publicacao->id_publicacoes }}">Excluir publicação</button>
        </x-slot>
    </x-admin.modal>
@endforeach
