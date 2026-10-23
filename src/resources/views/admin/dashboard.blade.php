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
    @include('admin.cards')
@endsection