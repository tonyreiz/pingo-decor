<section id="projetos">
  <article class="cards">

    @foreach (($projetosDinamicos ?? collect()) as $projeto)
    @php
    $caminhoProjeto = 'pingo-decor/assets/' . ltrim($projeto->imagem_projetos, '/');
    $imagemProjeto = file_exists(public_path($caminhoProjeto))
    ? asset($caminhoProjeto)
    : asset('pingo-decor/assets/imagem-indisponivel.svg');
    @endphp
    <a class="card" href="{{ route('projetos.index') }}">
      <img src="{{ $imagemProjeto }}" alt="{{ $projeto->nome_projetos }}" loading="lazy" decoding="async">
      <p>{{ mb_strtoupper($projeto->nome_projetos) }}</p>
    </a>
    @endforeach

    


  </article>

  <div class="veja">
    <a href="{{ route('projetos.index') }}">Veja Mais</a>
  </div>
</section>