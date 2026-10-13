@extends('layout.site')
@section('title', 'Projetos | Pingo Decor')
@section('content')
<!-- SEÇÃO PROJETOS -->
<section id="projetos"></section>

<div class="projetos-linha">

  @foreach (($projetosDinamicos ?? collect()) as $projetoDinamico)
    @php
      $caminhoProjeto = 'pingo-decor/assets/' . ltrim($projetoDinamico->imagem_projetos, '/');
      $imagemProjeto = file_exists(public_path($caminhoProjeto))
        ? asset($caminhoProjeto)
        : asset('pingo-decor/assets/imagem-indisponivel.svg');
    @endphp
    <article class="projeto-card">
      <div class="projeto quarto">
        <img src="{{ $imagemProjeto }}" alt="{{ $projetoDinamico->nome_projetos }}" loading="lazy">
        <p>{{ mb_strtoupper($projetoDinamico->nome_projetos) }}</p>
      </div>
    </article>
  @endforeach









<!-- GSAP -->


<!-- ScrollTrigger -->
@endsection
