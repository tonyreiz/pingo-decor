<!doctype html>
<html lang="pt-BR">
@include('partials.partialsAdmin.headAdmin')
<body class="admin-body">
<div class="app-wrapper">
    @include('partials.partialsAdmin.menuLateral')
    @include('partials.partialsAdmin.topoAdmin')
    <main class="app-main">
        <div class="admin-page container-fluid">
            <div class="admin-page-heading">
                <div>
                    <p class="admin-eyebrow">@yield('eyebrow', 'PAINEL PINGO DECOR')</p>
                    <h1>@yield('heading', 'Visão geral')</h1>
                    <p class="admin-description">@yield('description', 'Organize o conteúdo visual do seu site em um só lugar.')</p>
                </div>
                <div class="admin-heading-actions">@yield('actions')</div>
            </div>

            @if (session('sucesso'))
                <div class="admin-alert admin-alert-success" role="alert">
                    <span class="admin-alert-icon" aria-hidden="true">&#10003;</span>
                    <div>
                        <strong>Alteração concluída</strong>
                        <p>{{ session('sucesso') }}</p>
                    </div>
                    <button type="button" class="admin-alert-close" data-admin-alert-close aria-label="Fechar aviso">&times;</button>
                </div>
            @endif

            @if (session('erro') || $errors->any())
                <div class="admin-alert admin-alert-error" role="alert">
                    <span class="admin-alert-icon" aria-hidden="true">!</span>
                    <div>
                        <strong>Não foi possível concluir</strong>
                        <p>{{ session('erro') ?? $errors->first() }}</p>
                    </div>
                    <button type="button" class="admin-alert-close" data-admin-alert-close aria-label="Fechar aviso">&times;</button>
                </div>

                
            @endif

            @yield('content')
        </div>
    </main>
    @include('partials.partialsAdmin.rodapeAdmin')
</div>
<div class="admin-backdrop" data-admin-close></div>
@include('partials.partialsAdmin.script')
</body>
</html>
