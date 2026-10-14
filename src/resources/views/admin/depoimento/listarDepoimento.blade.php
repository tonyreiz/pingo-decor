@php
    $ativos = $listaDepoimento->where('status_depoimento', 'Ativo')->count();
    $inativos = $listaDepoimento->where('status_depoimento', 'Inativo')->count();
@endphp

<section class="admin-budget-summary" aria-label="Resumo dos depoimentos">
    <article class="admin-budget-stat admin-budget-stat-total">
        <div class="admin-budget-stat-heading">
            <span>Total de depoimentos</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#128172;</span>
        </div>
        <strong>{{ $totalDepoimentos }}</strong>
        <small>depoimentos cadastrados</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-approved">
        <div class="admin-budget-stat-heading">
            <span>Ativos</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#10003;</span>
        </div>
        <strong>{{ $totalAtivos }}</strong>
        <small>publicados no site</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-pending">
        <div class="admin-budget-stat-heading">
            <span>Inativos</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#9201;</span>
        </div>
        <strong>{{ $totalInativos }}</strong>
        <small>não publicados</small>
    </article>

    <article class="admin-budget-stat admin-budget-stat-value">
        <div class="admin-budget-stat-heading">
            <span>Média das notas</span>
            <span class="admin-budget-stat-icon" aria-hidden="true">&#9733;</span>
        </div>
        <strong>{{ number_format($mediaNotas, 1, ',', '.') }}/5</strong>
        <small>avaliação média dos clientes</small>
    </article>
</section>

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2>Lista de depoimentos</h2>
            <p>Consulte as avaliações e controle quais depoimentos aparecem no site.</p>
        </div>
        <span class="admin-tag">{{ $listaDepoimento->count() }} registros</span>
    </div>

    <form action="{{ route('admin.depoimento.index') }}" method="GET" class="admin-filter-row">
        <div class="admin-field" style="flex: 1; min-width: 220px;">
            <input
                type="search"
                name="busca"
                value="{{ request('busca') }}"
                placeholder="Buscar por título, descrição ou cliente..."
                aria-label="Buscar depoimentos"
            >
        </div>

        <div class="admin-field">
            <select name="status" aria-label="Filtrar por status">
                <option value="">Todos os status</option>
                <option value="Ativo" @selected(request('status') === 'Ativo')>Ativos</option>
                <option value="Inativo" @selected(request('status') === 'Inativo')>Inativos</option>
            </select>
        </div>

        <button type="submit" class="admin-primary-btn">Filtrar</button>
        <a href="{{ route('admin.depoimento.index') }}" class="admin-outline-btn">Limpar</a>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Título</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Depoimento</th>
                    <th scope="col">Nota</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($listaDepoimento as $depoimento)
                    @php
                        $statusClass = $depoimento->status_depoimento === 'Ativo'
                            ? 'published'
                            : 'inactive';
                    @endphp

                    <tr>
                        <td>
                            <span class="admin-code">
                                #{{ str_pad($depoimento->id_depoimento, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <td>
                            <span class="cell-primary">
                                {{ $depoimento->titulo_depoimento }}
                            </span>
                        </td>

                        <td>
                            {{ $depoimento->cliente->nome_cliente ?? 'Cliente não encontrado' }}
                        </td>

                        <td>
                            <span class="cell-secondary">
                                {{ \Illuminate\Support\Str::limit($depoimento->descricao_depoimento, 80) }}
                            </span>
                        </td>

                        <td>
                            <span class="admin-money">
                                &#9733; {{ number_format($depoimento->nota_depoimento, 1, ',', '.') }}
                            </span>
                        </td>

                        <td>
                            <span class="admin-status {{ $statusClass }}">
                                {{ $depoimento->status_depoimento }}
                            </span>
                        </td>

                        <td>
                            <form
                                action="{{ route('admin.depoimento.status', $depoimento->id_depoimento) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                @if ($depoimento->status_depoimento === 'Ativo')
                                    <input type="hidden" name="status_depoimento" value="Inativo">
                                    <button type="submit" class="admin-action admin-action-danger">
                                        Inativar
                                    </button>
                                @else
                                    <input type="hidden" name="status_depoimento" value="Ativo">
                                    <button type="submit" class="admin-action">
                                        Ativar
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="admin-table-empty">
                                <span aria-hidden="true">&#128172;</span>
                                <strong>Nenhum depoimento encontrado</strong>
                                <small>Experimente alterar os filtros de pesquisa.</small>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card-footer">
        Total de depoimentos encontrados: {{ $listaDepoimento->count() }}
    </div>
</div>
