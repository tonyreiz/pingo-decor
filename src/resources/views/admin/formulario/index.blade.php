@extends('layout.admin')

@section('title', 'Solicitações | Painel Pingo Decor')
@section('navtitle', 'Solicitações')
@section('eyebrow', 'CONTATOS DO SITE')
@section('heading', 'Solicitações de proposta')
@section('description', 'Consulte os dados enviados pelo formulário de contato.')

@section('content')
    <section class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2>Solicitações recebidas</h2>
                <p>Os dados são enviados diretamente ao banco de dados do site.</p>
            </div>
            <span class="admin-tag">{{ $formularios->total() }} registros</span>
        </div>
        <form action="{{ route('admin.formulario.index') }}" method="GET" class="admin-filter-row">
            <div class="admin-field" style="flex: 1; min-width: 220px;">
                <input type="search" name="busca" value="{{ request('busca') }}" placeholder="Buscar por nome, e-mail, telefone ou projeto" aria-label="Buscar solicitações">
            </div>
            <button type="submit" class="admin-primary-btn">Buscar</button>
            <a href="{{ route('admin.formulario.index') }}" class="admin-outline-btn">Limpar</a>
        </form>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Data</th><th>Nome</th><th>E-mail</th><th>Telefone</th><th>Endereço</th><th>Projeto</th><th>Metragem</th><th>Prazo</th><th>Detalhes</th><th>Ações</th></tr></thead>
                <tbody>
                    @forelse ($formularios as $formulario)
                        <tr>
                            <td>{{ $formulario->data_criacao_formulario ? \Carbon\Carbon::parse($formulario->data_criacao_formulario)->format('d/m/Y H:i') : '—' }}</td>
                            <td><span class="cell-primary">{{ $formulario->nome }}</span></td>
                            <td>{{ $formulario->email ?: '—' }}</td>
                            <td>{{ $formulario->telefone }}</td><td>{{ $formulario->endereco }}</td>
                            <td>{{ $formulario->tipo_projeto }}</td>
                            <td>{{ $formulario->metragem ? number_format($formulario->metragem, 2, ',', '.') . ' m²' : '—' }}</td>
                            <td>{{ $formulario->prazo ?: '—' }}</td>
                            <td>
                                @if ($formulario->profissao)<p><strong>Profissão:</strong> {{ $formulario->profissao }}</p>@endif
                                @if ($formulario->descricao)<p><strong>Projeto:</strong> {{ $formulario->descricao }}</p>@endif
                                @if ($formulario->observacoes)<p><strong>Observações:</strong> {{ $formulario->observacoes }}</p>@endif
                                @if (!$formulario->profissao && !$formulario->descricao && !$formulario->observacoes)—@endif
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <button type="button" class="admin-action" data-admin-modal-open="modalClienteFormulario{{ $formulario->id_formulario }}" aria-haspopup="dialog">
                                        Criar cliente
                                    </button>
                                    <button type="button" class="admin-action admin-action-danger" data-admin-modal-open="modalExcluirFormulario{{ $formulario->id_formulario }}" aria-haspopup="dialog">
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10"><div class="admin-table-empty"><strong>Nenhuma solicitação encontrada</strong><small>Quando alguém preencher o formulário do site, ela aparecerá aqui.</small></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-card-footer">{{ $formularios->links() }}</div>
    </section>

    @foreach ($formularios as $formulario)
        <x-admin.modal id="modalClienteFormulario{{ $formulario->id_formulario }}" title="Cadastrar cliente a partir da solicitação" size="large">
            <form
                class="admin-form"
                id="formClienteFormulario{{ $formulario->id_formulario }}"
                action="{{ route('admin.cliente.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="admin-form-grid">
                    <div class="admin-field">
                        <label for="nomeClienteFormulario{{ $formulario->id_formulario }}">Nome</label>
                        <input id="nomeClienteFormulario{{ $formulario->id_formulario }}" name="nome_cliente" type="text" maxlength="50" value="{{ $formulario->nome }}" required>
                    </div>
                    <div class="admin-field">
                        <label for="emailClienteFormulario{{ $formulario->id_formulario }}">E-mail</label>
                        <input id="emailClienteFormulario{{ $formulario->id_formulario }}" name="email_cliente" type="email" maxlength="80" value="{{ $formulario->email }}" required>
                    </div>
                    <div class="admin-field">
                        <label for="telefoneClienteFormulario{{ $formulario->id_formulario }}">Telefone</label>
                        <input id="telefoneClienteFormulario{{ $formulario->id_formulario }}" name="telefone_cliente" type="tel" maxlength="20" value="{{ $formulario->telefone }}">
                    </div>
                    <div class="admin-field">
                        <label for="senhaClienteFormulario{{ $formulario->id_formulario }}">Senha de acesso</label>
                        <input id="senhaClienteFormulario{{ $formulario->id_formulario }}" name="senha_cliente" type="password" minlength="6" maxlength="255" autocomplete="new-password" required>
                    </div>
                    <div class="admin-field">
                        <label for="statusClienteFormulario{{ $formulario->id_formulario }}">Status</label>
                        <select id="statusClienteFormulario{{ $formulario->id_formulario }}" name="status_cliente" required>
                            <option value="Ativo">Ativo</option>
                            <option value="Inativo">Inativo</option>
                        </select>
                    </div>
                    <div class="admin-field admin-field-full">
                        <label for="fotoClienteFormulario{{ $formulario->id_formulario }}">Foto</label>
                        <input id="fotoClienteFormulario{{ $formulario->id_formulario }}" name="foto_cliente" type="file" accept="image/jpeg,image/png,image/webp">
                        <small>Opcional. Sem foto, será usada a imagem padrão.</small>
                    </div>
                </div>
            </form>
            <x-slot name="footer">
                <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
                <button type="submit" class="admin-primary-btn" form="formClienteFormulario{{ $formulario->id_formulario }}">Cadastrar cliente</button>
            </x-slot>
        </x-admin.modal>

        <x-admin.modal id="modalExcluirFormulario{{ $formulario->id_formulario }}" title="Excluir solicitação" size="small" variant="danger">
            <form id="formExcluirFormulario{{ $formulario->id_formulario }}" action="{{ route('admin.formulario.destroy', $formulario->id_formulario) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
            <div class="admin-delete-message">
                <span class="admin-delete-icon" aria-hidden="true">!</span>
                <div>
                    <p>Tem certeza que deseja excluir a solicitação de <strong>{{ $formulario->nome }}</strong>?</p>
                    <small>Esta ação não poderá ser desfeita.</small>
                </div>
            </div>
            <x-slot name="footer">
                <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
                <button type="submit" class="admin-danger-btn" form="formExcluirFormulario{{ $formulario->id_formulario }}">Excluir solicitação</button>
            </x-slot>
        </x-admin.modal>
    @endforeach
@endsection
