<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#8B5E3C">
    <title>Documentação das APIs | Pingo de Cor</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('pingo-decor/assets/logo.svg') }}">
    <link rel="stylesheet" href="{{ asset('pingo-decor/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('pingo-decor/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('pingo-decor/css/documentacao.css') }}">
</head>
<body>
    @php
        // O status é calculado a partir das rotas registradas pelo Laravel.
        $secoes = [
            ['Sistema', 'Endpoint de saúde da API para monitoramento da disponibilidade do serviço.', [
                ['GET','/status','Consultar status da API e identificação da aplicação',true],
            ]],
            ['Autenticação', null, [
                ['POST','/register','Cadastrar cliente',false], ['POST','/login','Realizar login',false], ['POST','/logout','Encerrar sessão',false],
                ['POST','/password/forgot','Solicitar recuperação de senha',false], ['POST','/password/verify','Verificar código de recuperação',false],
                ['PUT','/password/reset','Redefinir senha',false], ['GET','/me','Consultar usuário autenticado',false],
            ]],
            ['Perfil do cliente', null, [
                ['GET','/profile','Consultar perfil do cliente',false], ['PUT','/profile','Atualizar informações do perfil',false], ['PUT','/profile/password','Alterar senha',false],
            ]],
            ['Projetos e portfólio', 'Os projetos disponíveis no portfólio e os projetos contratados compartilham a mesma estrutura de armazenamento.', [
                ['GET','/projetos','Listar projetos disponíveis',true], ['GET','/projetos/{id}','Consultar detalhes de um projeto',false],
                ['POST','/projetos','Cadastrar projeto',false], ['PUT','/projetos/{id}','Atualizar projeto',false], ['DELETE','/projetos/{id}','Excluir projeto',false],
            ]],
            ['Briefing', null, [
                ['POST','/projetos/{id}/briefing','Registrar briefing do projeto',false], ['GET','/projetos/{id}/briefing','Consultar briefing',false], ['PUT','/projetos/{id}/briefing','Atualizar briefing',false],
            ]],
            ['Favoritos', 'Os favoritos são associados ao cliente, permitindo que cada usuário mantenha sua própria lista de projetos preferidos.', [
                ['GET','/favoritos','Listar projetos favoritos do cliente',true], ['POST','/favoritos','Adicionar projeto aos favoritos',true], ['DELETE','/favoritos/{id}','Remover projeto dos favoritos',true],
            ]],
            ['Orçamentos', 'Após a aprovação do orçamento, o funcionário realiza manualmente o cadastro do projeto correspondente no sistema.', [
                ['POST','/orcamentos','Solicitar orçamento',false], ['GET','/orcamentos','Listar orçamentos do cliente',false], ['GET','/orcamentos/{id}','Consultar orçamento específico',false],
                ['PUT','/orcamentos/{id}','Atualizar informações do orçamento',false], ['PATCH','/orcamentos/{id}/status','Atualizar situação do orçamento',false],
            ]],
            ['Agendamentos', null, [
                ['POST','/agendamentos','Criar agendamento',false], ['GET','/agendamentos','Listar agendamentos do cliente',false], ['GET','/agendamentos/{id}','Consultar agendamento específico',false],
                ['PUT','/agendamentos/{id}','Atualizar agendamento',false], ['PATCH','/agendamentos/{id}/status','Alterar situação do agendamento',false], ['DELETE','/agendamentos/{id}','Cancelar agendamento',false],
            ]],
            ['Atualizações e acompanhamento da obra', 'Os funcionários registram e administram as atualizações. Os clientes podem consultar as informações disponibilizadas.', [
                ['GET','/projetos/{id}/atualizacoes','Listar atualizações da obra',true], ['GET','/atualizacoes/{id}','Consultar atualização específica',false],
                ['POST','/projetos/{id}/atualizacoes','Registrar atualização da obra',true], ['PUT','/atualizacoes/{id}','Editar atualização',false], ['DELETE','/atualizacoes/{id}','Excluir atualização',false],
            ]],
            ['Depoimentos e avaliações', null, [
                ['GET','/depoimentos','Listar depoimentos',true], ['GET','/depoimentos/{id}','Consultar depoimento específico',false], ['POST','/depoimentos','Cadastrar depoimento',true],
                ['PUT','/depoimentos/{id}','Editar depoimento',false], ['DELETE','/depoimentos/{id}','Excluir depoimento',false],
            ]],
            ['Administração — Funcionários', 'A área administrativa deve exigir autorização de funcionário.', [
                ['GET','/admin/projetos','Listar projetos administrados',false], ['POST','/admin/projetos','Criar projeto após aprovação do orçamento',false],
                ['PUT','/admin/projetos/{id}','Atualizar informações do projeto',false], ['PUT','/admin/projetos/{id}/progress','Atualizar percentual de conclusão',false],
                ['PUT','/admin/projetos/{id}/stages/{stageId}','Atualizar etapa do projeto',false], ['POST','/admin/projetos/{id}/atualizacoes','Registrar atualização da obra',false],
                ['DELETE','/admin/projetos/{id}','Excluir projeto',false],
            ]],
        ];

        $rotasApi = collect(\Illuminate\Support\Facades\Route::getRoutes())
            ->filter(fn($rota) => str_starts_with($rota->uri(), 'api/v1/'))
            ->flatMap(function ($rota) {
                $uri = '/' . substr($rota->uri(), strlen('api/v1/'));
                return collect($rota->methods())
                    ->reject(fn($metodo) => in_array($metodo, ['HEAD', 'OPTIONS']))
                    ->map(fn($metodo) => [strtoupper($metodo), $uri]);
            })->values();

        $rotasDocumentadas = [];
        foreach ($secoes as &$secao) {
            foreach ($secao[2] as &$endpoint) {
                $chave = [strtoupper($endpoint[0]), $endpoint[1]];
                $endpoint[3] = $rotasApi->contains(fn($rota) => $rota === $chave);
                $rotasDocumentadas[] = $chave;
            }
            unset($endpoint);
        }
        unset($secao);

        // Inclui automaticamente rotas novas que ainda não tenham uma descrição manual.
        $rotasNovas = $rotasApi->reject(fn($rota) => in_array($rota, $rotasDocumentadas, true));
        if ($rotasNovas->isNotEmpty()) {
            $secoes[] = ['Outros endpoints implementados', 'Rotas registradas no backend ainda sem descrição específica.',
                $rotasNovas->map(fn($rota) => [$rota[0], $rota[1], 'Endpoint implementado no backend', true])->all()];
        }

        $totalEndpoints = array_sum(array_map(fn($secao) => count($secao[2]), $secoes));
    @endphp

    <header class="docs-header">
        <div class="docs-header-inner">
            <a class="brand-logo" href="{{ route('home') }}"><img src="{{ asset('pingo-decor/assets/logo.svg') }}" alt="Pingo de Cor"></a>
            <a class="back-link" href="{{ route('home') }}">← Voltar ao site</a>
        </div>
    </header>
    <section class="hero">
        <div class="hero-inner">
            <div class="eyebrow">Documentação técnica · Versão 1.0</div>
            <h1>APIs do Pingo de Cor</h1>
            <p>Mapa de endpoints, funcionalidades e regras gerais para integração com os serviços do projeto.</p>
            <div class="hero-meta"><span class="meta-chip">REST API</span><span class="meta-chip">JSON</span><span class="meta-chip">Prefixo {{ url('/api/v1') }}</span></div>
        </div>
    </section>

    <main class="page">
        <div class="overview">
            <section class="panel">
                <h2>Sobre esta documentação</h2>
                <p>As APIs conectam o backend às interfaces de clientes e funcionários para gerenciar projetos de interiores, contratação de serviços e acompanhamento de obras. A situação de cada endpoint reflete as rotas atualmente declaradas no backend.</p>
                <div class="base-url"><strong>URL base:</strong> <code>{{ url('/api/v1') }}</code></div>
            </section>
            <section class="panel">
                <h3>Referência rápida</h3>
                <div class="meta-list">
                    <div class="meta-item"><span>Projeto</span><strong>Pingo de Cor</strong></div>
                    <div class="meta-item"><span>Versão</span><strong>1.0 · v1</strong></div>
                    <div class="meta-item"><span>Formato</span><strong>JSON</strong></div>
                    <div class="meta-item"><span>Endpoints listados</span><strong>{{ $totalEndpoints }}</strong></div>
                </div>
            </section>
        </div>

        <nav class="section-nav" aria-label="Navegar pelas seções">
            @foreach ($secoes as $indice => $secao)
                <a href="#secao-{{ $indice + 1 }}">{{ $secao[0] }}</a>
            @endforeach
            <a href="#regras">Regras gerais</a>
        </nav>

        @foreach ($secoes as $indice => [$titulo, $nota, $endpoints])
            <section class="section-card" id="secao-{{ $indice + 1 }}">
                <div class="section-heading"><span class="section-number">{{ str_pad($indice + 1, 2, '0', STR_PAD_LEFT) }}</span><div><h2>{{ $titulo }}</h2>@if($nota)<p>{{ $nota }}</p>@endif</div></div>
                <div class="table-wrap"><table>
                    <thead><tr><th>Método</th><th>Rota</th><th>Finalidade</th><th>Situação</th></tr></thead>
                    <tbody>
                        @foreach ($endpoints as [$metodo, $rota, $finalidade, $implementado])
                            <tr>
                                <td><span class="method method-{{ strtolower($metodo) }}">{{ $metodo }}</span></td>
                                <td><code class="route">/api/v1{{ $rota }}</code></td>
                                <td class="purpose">{{ $finalidade }}</td>
                                <td><span class="status {{ $implementado ? 'status-live' : 'status-planned' }}">{{ $implementado ? 'Implementado' : 'Planejado' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
                @if($nota)<div class="note"><strong>Observação:</strong> {{ $nota }}</div>@endif
            </section>
        @endforeach

        <section class="section-card" id="regras">
            <div class="section-heading"><span class="section-number">14</span><div><h2>Regras gerais de utilização</h2><p>Convenções compartilhadas por todos os endpoints.</p></div></div>
            <div class="rules">
                <div class="rule"><b>01</b><span>Todas as rotas utilizam o prefixo <code>/api/v1</code>.</span></div>
                <div class="rule"><b>02</b><span>As requisições e respostas utilizam o formato JSON.</span></div>
                <div class="rule"><b>03</b><span>Rotas que manipulam informações particulares devem exigir autenticação.</span></div>
                <div class="rule"><b>04</b><span>Rotas administrativas devem exigir autorização de funcionário.</span></div>
                <div class="rule"><b>05</b><span>Os identificadores <code>{id}</code> representam os registros consultados ou modificados.</span></div>
                <div class="rule"><b>06</b><span>Projetos do portfólio e projetos contratados compartilham a mesma estrutura de armazenamento.</span></div>
                <div class="rule"><b>07</b><span>Atualizações financeiras e de obra utilizam a tabela <code>tbl_atualizacao_obra</code>.</span></div>
                <div class="rule"><b>08</b><span>Em atualizações de obra, <code>tipo_atualizacao</code> diferencia informações de obra e financeiras.</span></div>
            </div>
        </section>
        <p class="note"><strong>Métodos HTTP:</strong> GET consulta informações · POST cadastra ou envia informações · PUT atualiza · PATCH atualiza parcialmente · DELETE exclui.</p>
    </main>
    <footer class="footer">Pingo de Cor · Documentação técnica das APIs · © 2026 · <a href="{{ route('home') }}">Voltar ao site</a></footer>
</body>
</html>
