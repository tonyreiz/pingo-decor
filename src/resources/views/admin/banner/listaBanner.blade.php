<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2>Banners e destaques</h2>
            <p>Imagens de capa e chamadas visuais da página inicial.</p>
        </div>
        <span class="admin-tag">{{ $listarBanner->count() }} registros</span>
    </div>

    <div class="admin-filter-row">
        <div class="admin-search-fake" aria-label="Busca de banners">
            <span aria-hidden="true">&#128269;</span> Buscar banner...
        </div>
        <div class="admin-filter-fake" aria-label="Filtros de banners">
            <span class="selected">Todos</span><span>Publicados</span><span>Rascunhos</span>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">Imagem</th>
                    <th scope="col">Título</th>
                    <th scope="col">Status</th>
                    <th scope="col">Atualizado em</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listarBanner as $banner)
                <tr>
                    <td>
                        <img class="cell-image" src="{{ asset('pingo-decor/assets/' . ltrim($banner->imagem_banner, '/')) }}" alt="{{ $banner->titulo_banner }}"
                            loading="lazy">
                    </td>
                    <td><span class="cell-primary">{{ $banner->titulo_banner }}</span></td>

                    <td>
                        @php($statusBanner = trim((string) data_get($banner, 'status_banner')))
                        <span
                            class="admin-status {{ mb_strtolower($statusBanner) === 'inativo' ? 'inactive' : data_get($banner, 'status_tone', 'draft') }}">
                            {{ $statusBanner }}
                        </span>
                    </td>
                    <td>{{ optional($banner->data_atualizacao_banner)->format('d/m/Y H:i') ?? date('d/m/Y H:i', strtotime($banner->data_atualizacao_banner)) }}</td>
                    <td>
                        <div class="admin-actions">
                            <button type="button" class="admin-action"
                                data-admin-modal-open="modalEditarBanner{{ $banner->id_banner }}"
                                aria-haspopup="dialog">Editar</button>
                            <button type="button" class="admin-action admin-action-danger"
                                data-admin-modal-open="modalExcluirBanner{{ $banner->id_banner }}"
                                aria-haspopup="dialog">Excluir</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Nenhum banner cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card-footer">Total de banners: {{ $listarBanner->count() }}</div>
</div>

<x-admin.modal id="modalCriarBanner" title="Criar banner">
    <form
        class="admin-form"
        id="formCriarBanner"
        action="{{ route('admin.banner.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="admin-form-grid">
            <div class="admin-field admin-field-full">
                <label for="criarTituloBanner">Título</label>
                <input id="criarTituloBanner" name="titulo_banner" type="text" placeholder="Título do banner" required>
            </div>
            <div class="admin-field admin-field-full">
                <label for="criarImagemBanner">Imagem</label>
                <input id="criarImagemBanner" name="imagem_banner" type="file" accept="image/*" required>
            </div>
            <div class="admin-field">
                <label for="criarStatusBanner">Status</label>
                <select id="criarStatusBanner" name="status_banner" required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
        <button type="submit" class="admin-primary-btn" form="formCriarBanner">Criar banner</button>
    </x-slot>
</x-admin.modal>

@foreach ($listarBanner as $banner)
    <x-admin.modal id="modalEditarBanner{{ $banner->id_banner }}" title="Editar banner">
        <form
            class="admin-form"
            id="formEditarBanner{{ $banner->id_banner }}"
            action="{{ route('admin.banner.update', $banner->id_banner) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="admin-form-grid">

                <div class="admin-field admin-field-full">
                    <label for="editarTituloBanner{{ $banner->id_banner }}">Título</label>

                    <input id="editarTituloBanner{{ $banner->id_banner }}" name="titulo_banner" type="text"
                        value="{{ $banner->titulo_banner }}" required>
                </div>

                <div class="admin-field admin-field-full">
                    <label for="editarImagemBanner{{ $banner->id_banner }}">Substituir imagem</label>
                    <input id="editarImagemBanner{{ $banner->id_banner }}" name="imagem_banner" type="file"
                        accept="image/*">
                </div>

                <div class="admin-field">

                    <label for="editarStatusBanner{{ $banner->id_banner }}">Status</label>

                    <select id="editarStatusBanner{{ $banner->id_banner }}" name="status_banner" required>
                        <option value="Ativo" @selected(mb_strtolower((string) $banner->status_banner) === 'ativo')>Ativo
                        </option>
                        <option value="Inativo" @selected(mb_strtolower((string) $banner->status_banner) === 'inativo')>
                            Inativo</option>
                    </select>

                </div>

            </div>

        </form>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-primary-btn" form="formEditarBanner{{ $banner->id_banner }}">Salvar alterações</button>
        </x-slot>
    </x-admin.modal>

    <x-admin.modal id="modalExcluirBanner{{ $banner->id_banner }}" title="Excluir banner" size="small" variant="danger">
        <form
            id="formExcluirBanner{{ $banner->id_banner }}"
            action="{{ route('admin.banner.destroy', $banner->id_banner) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
        </form>

        <div class="admin-delete-message">
            <span class="admin-delete-icon" aria-hidden="true">!</span>
            <div>
                <p>Tem certeza que deseja excluir <strong>{{ $banner->titulo_banner }}</strong>?</p>
                <small>Esta ação não poderá ser desfeita.</small>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
            <button type="submit" class="admin-danger-btn" form="formExcluirBanner{{ $banner->id_banner }}">Excluir banner</button>
        </x-slot>
    </x-admin.modal>
@endforeach