@extends('layout.admin')
@section('title', 'Visão geral | Painel Pingo Decor')
@section('navtitle', 'Visão geral')             
@section('eyebrow', 'BEM-VINDA AO SEU ESPAÇO')
@section('heading', 'Seu site, com a sua essência')
@section('description', 'Uma visão clara do conteúdo e das imagens que compõem a Pingo Decor.')
@section('content')
    <section class="admin-hero" aria-label="Destaque do painel">
        <div class="admin-hero-content">
            <span class="admin-hero-kicker">CONTEÚDO E IDENTIDADE</span>
            <h2>Ambientes especiais começam com boas histórias.</h2>
            <p>Organize as imagens, textos e projetos que apresentam seu trabalho em cada página do site.</p>
            <a href="{{ route('admin.banner.index') }}" class="admin-primary-btn">Explorar projetos <span>&rarr;</span></a>
        </div>
    </section>
    <section class="admin-card" style="margin-top: 24px;">
        <div class="admin-card-header">
            <div>
                <h2>Solicitações de proposta</h2>
                <p>{{ $totalFormularios }} solicitações recebidas pelo formulário do site.</p>
            </div>
            <a href="{{ route('admin.formulario.index') }}" class="admin-primary-btn">Ver solicitações</a>
        </div>
        <div class="admin-card-body">
            @forelse ($formulariosRecentes as $formulario)
                <p><strong>{{ $formulario->nome }}</strong> — {{ $formulario->tipo_projeto }}
                    <span class="cell-secondary">{{ $formulario->email }} · {{ $formulario->data_criacao_formulario ? \Carbon\Carbon::parse($formulario->data_criacao_formulario)->format('d/m/Y H:i') : '' }}</span>
                </p>
            @empty
                <p>Nenhuma solicitação recebida ainda.</p>
            @endforelse
        </div>
    </section>
    @include('admin.cards')
@endsection
