<aside class="app-sidebar admin-sidebar" aria-label="Menu administrativo">
    <a class="admin-brand" href="{{ route('admin.dashboard') }}">
        <span class="admin-brand-mark"><img src="{{ asset('pingo-decor/assets/img/logotipo.svg') }}"
                alt="Pingo Decor"></span>
        <span class="admin-brand-label">Painel de conteúdo</span>
    </a>
    <div class="admin-sidebar-inner">
        <p class="admin-nav-heading">GERENCIAR</p>
        <nav class="admin-nav" aria-label="Páginas do painel">

            <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}"><span class="admin-nav-icon">&#9635;</span><span>Visão
                    geral</span></a>


            <a class="admin-nav-link {{ request()->routeIs('admin.banner.*') ? 'active' : '' }}"
                href="{{ route('admin.banner.index') }}"><span
                    class="admin-nav-icon">&#9635;</span><span>Banners</span></a>


            <a class="admin-nav-link {{ request()->routeIs('admin.cliente.*') ? 'active' : '' }}"
                href="{{ route('admin.cliente.index') }}"><span
                    class="admin-nav-icon">&#9635;</span><span>Funcionários</span></a>


            <a class="admin-nav-link {{ request()->routeIs('admin.publicacoes.*') ? 'active' : '' }}"
                href="{{ route('admin.publicacoes.index') }}"><span
                    class="admin-nav-icon">&#9645;</span><span>Publicações</span></a>

            <a class="admin-nav-link {{ request()->routeIs('admin.projetos.*') ? 'active' : '' }}"
                href="{{ route('admin.projetos.index') }}"><span
                    class="admin-nav-icon">&#9645;</span><span>Projetos</span></a>

            <a class="admin-nav-link {{ request()->routeIs('admin.orcamento.*') ? 'active' : '' }}"
                href="{{ route('admin.orcamento.index') }}"><span
                    class="admin-nav-icon">&#9645;</span><span>Orçamentos</span></a>

            <a class="admin-nav-link {{ request()->routeIs('admin.contato.*') ? 'active' : '' }}"
                href="{{ route('admin.contato.index') }}"><span
                    class="admin-nav-icon">&#9635;</span><span>Cliente</span></a>

        </nav>
        <p class="admin-nav-heading admin-nav-heading-spaced">PERSONALIZAÇÃO</p>
        <nav class="admin-nav" aria-label="Personalização">

        </nav>
       
    </div>
</aside>