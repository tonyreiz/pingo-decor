@extends('layout.admin')

@section('title', 'Briefings | Painel Pingo Decor')
@section('navtitle', 'Briefings')
@section('eyebrow', 'PROJETOS E CLIENTES')
@section('heading', 'Briefings dos projetos')
@section('description', 'Visualize e atualize as informações registradas para cada projeto.')

@section('actions')
    @if ($projetosDisponiveis->isNotEmpty())
        <button
            type="button"
            class="admin-primary-btn"
            data-admin-modal-open="modalCriarBriefing"
            aria-haspopup="dialog"
        >+ Criar briefing</button>
    @endif
@endsection

@section('content')
    <section class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2>Briefings cadastrados</h2>
                <p>O conteúdo pode conter os campos definidos para cada projeto.</p>
            </div>
            <span class="admin-tag">{{ $briefings->total() }} registros</span>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Projeto</th><th>Atualizado em</th><th>Conteúdo</th><th>Ações</th></tr></thead>
                <tbody>
                    @forelse ($briefings as $briefing)
                        <tr>
                            <td><span class="cell-primary">{{ $briefing->nome_projetos }}</span></td>
                            <td>{{ $briefing->data_atualizacao_briefing ? \Carbon\Carbon::parse($briefing->data_atualizacao_briefing)->format('d/m/Y H:i') : '—' }}</td>
                            <td>
                                <div class="briefing-fields">
                                    @foreach ($briefing->conteudo_briefing as $campo => $valor)
                                        <p><strong>{{ is_string($campo) ? str($campo)->replace('_', ' ')->ucfirst() : 'Item ' . ($campo + 1) }}:</strong>
                                            {{ is_scalar($valor) ? ($valor === '' ? '—' : $valor) : json_encode($valor, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</p>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <button type="button" class="admin-action" data-admin-modal-open="modalBriefing{{ $briefing->id_briefing }}" aria-haspopup="dialog">Editar briefing</button>
                                <button type="button" class="admin-action" data-admin-modal-open="modalExcluirBriefing{{ $briefing->id_briefing }}" aria-haspopup="dialog">Excluir</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="admin-table-empty"><strong>Nenhum briefing cadastrado</strong><small>Quando um briefing for registrado para um projeto, ele aparecerá aqui.</small></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-card-footer">{{ $briefings->links() }}</div>
    </section>

    @if ($projetosDisponiveis->isNotEmpty())
        <x-admin.modal id="modalCriarBriefing" title="Criar briefing" size="large">
            <form class="admin-form" id="formCriarBriefing" action="{{ route('admin.briefing.store') }}" method="POST">
                @csrf
                <div class="admin-field admin-field-full">
                    <label for="projetoBriefing">Projeto</label>
                    <select id="projetoBriefing" name="id_projetos" required>
                        <option value="">Selecione um projeto</option>
                        @foreach ($projetosDisponiveis as $projeto)
                            <option value="{{ $projeto->id_projetos }}" @selected(old('id_projetos') == $projeto->id_projetos)>{{ $projeto->nome_projetos }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-field admin-field-full">
                    <label for="novoConteudoBriefing">Conteúdo do briefing (JSON)</label>
                    <textarea id="novoConteudoBriefing" name="conteudo_briefing" rows="14" required spellcheck="false">{{ old('conteudo_briefing', "{\n  \"ambiente\": \"\",\n  \"estilo\": \"\"\n}") }}</textarea>
                    <small>Informe os campos do projeto em JSON válido.</small>
                </div>
            </form>
            <x-slot name="footer">
                <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
                <button type="submit" class="admin-primary-btn" form="formCriarBriefing">Criar briefing</button>
            </x-slot>
        </x-admin.modal>
    @endif

    @foreach ($briefings as $briefing)
        <x-admin.modal id="modalBriefing{{ $briefing->id_briefing }}" title="Editar briefing · {{ $briefing->nome_projetos }}" size="large">
            <form class="admin-form" id="formBriefing{{ $briefing->id_briefing }}" action="{{ route('admin.briefing.update', $briefing->id_briefing) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="admin-field admin-field-full">
                    <label for="conteudoBriefing{{ $briefing->id_briefing }}">Conteúdo do briefing (JSON)</label>
                    <textarea id="conteudoBriefing{{ $briefing->id_briefing }}" name="conteudo_briefing" rows="14" required spellcheck="false">{{ json_encode($briefing->conteudo_briefing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</textarea>
                    <small>Edite os campos mantendo a estrutura JSON válida. Exemplo: { "ambiente": "Quarto", "estilo": "Natural" }</small>
                </div>
            </form>
            <x-slot name="footer">
                <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
                <button type="submit" class="admin-primary-btn" form="formBriefing{{ $briefing->id_briefing }}">Salvar briefing</button>
            </x-slot>
        </x-admin.modal>

        <x-admin.modal id="modalExcluirBriefing{{ $briefing->id_briefing }}" title="Excluir briefing" size="small" variant="danger">
            <p>Tem certeza de que deseja excluir o briefing de <strong>{{ $briefing->nome_projetos }}</strong>?</p>
            <form id="formExcluirBriefing{{ $briefing->id_briefing }}" action="{{ route('admin.briefing.destroy', $briefing->id_briefing) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
            <x-slot name="footer">
                <button type="button" class="admin-outline-btn" data-admin-modal-close>Cancelar</button>
                <button type="submit" class="admin-danger-btn" form="formExcluirBriefing{{ $briefing->id_briefing }}">Excluir briefing</button>
            </x-slot>
        </x-admin.modal>
    @endforeach
@endsection
