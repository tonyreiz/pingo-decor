@extends('layout.site')
@section('title', 'Publicações | Pingo Decor')
@section('content')
<section class="publicacoes">

  <div class="publicacoes-grid">

    @foreach (($publicacoesDinamicas ?? collect()) as $indicePublicacao => $publicacaoDinamica)
      @php
        $caminhoPublicacao = 'pingo-decor/assets/' . ltrim($publicacaoDinamica->imagem_publicacoes, '/');
        $imagemPublicacao = file_exists(public_path($caminhoPublicacao))
          ? asset($caminhoPublicacao)
          : asset('pingo-decor/assets/imagem-indisponivel.svg');
      @endphp
      <a href="{{ $publicacaoDinamica->link_publicacoes }}" target="_blank" rel="noopener noreferrer" class="pub-card">
        <div class="pub-img">
          <img src="{{ $imagemPublicacao }}" alt="{{ $publicacaoDinamica->titulo_publicacoes }}"
            loading="{{ $indicePublicacao === 0 ? 'eager' : 'lazy' }}" decoding="async"
            @if ($indicePublicacao === 0) fetchpriority="high" @endif>
        </div>
        <div class="pub-info">
          <h3>{{ mb_strtoupper($publicacaoDinamica->titulo_publicacoes) }}</h3>
          <p>{{ $publicacaoDinamica->descricao_publicacoes }}</p>
          <span class="btn-publicacao">Ver publicação →</span>
        </div>
      </a>
    @endforeach


  </div>

</section>
@endsection
