<header class="app-header admin-topbar">
    <div class="admin-topbar-left">
        <button type="button" class="admin-menu-button" data-admin-menu aria-label="Abrir menu"><span></span><span></span><span></span></button>
        <div class="admin-topbar-title"><small>ÁREA ADMINISTRATIVA</small><strong>@yield('navtitle', 'Visão geral')</strong></div>
    </div>
    <div class="admin-topbar-right">
        
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="admin-view-site">Ver site <span>&rarr;</span></a>
        @php($funcionarioLogado = auth()->user())
        <span class="admin-avatar" aria-label="{{ $funcionarioLogado->nome_funcionario ?? 'Funcionário' }}">
            <img class="admin-avatar"
                src="{{ asset('pingo-decor/assets/' . ltrim($funcionarioLogado->foto_funcionario ?? 'funcionario/imagem-indisponivel.svg', '/')) }}"
                alt="Foto de {{ $funcionarioLogado->nome_funcionario ?? 'Funcionário' }}">
        </span>
    </div>
</header>
