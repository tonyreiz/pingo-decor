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

    <a class="card" href="{{ route('projetos.show', 'quarto-olivia') }}">
      <img src="{{ asset('pingo-decor/assets/img/olivia.webp') }}" loading="lazy" decoding="async">
      <p>QUARTO OLIVIA</p>
    </a>

    <a class="card" href="{{ route('projetos.show', 'quarto-matteo') }}">
      <img src="{{ asset('pingo-decor/assets/img/_mg_0092.jpg') }}" loading="lazy" decoding="async">
      <p>QUARTO MATTEO</p>
    </a>

    <a class="card" href="{{ route('projetos.show', 'quarto-lucca') }}">
      <img src="{{ asset('pingo-decor/assets/img/lucca.webp') }}" loading="lazy" decoding="async">
      <p>QUARTO LUCCA</p>
    </a>

    <a class="card" href="{{ route('projetos.show', 'brinquedoteca') }}">
      <img src="{{ asset('pingo-decor/assets/img/brinquedoteca.jpg') }}" loading="lazy" decoding="async">
      <p>BRINQUEDOTECA</p>
    </a>

    <a class="card" href="{{ route('projetos.show', 'quarto-julia-isabella') }}">
      <img src="{{ asset('pingo-decor/assets/img/_mg_8856.jpg') }}" loading="lazy" decoding="async">
      <p> QUARTO JULIA & ISABELLA</p>
    </a>

    <a class="card" href="{{ route('projetos.show', 'quarto-dan-ava') }}">
      <img src="{{ asset('pingo-decor/assets/img/_MG_1853.jpg') }}" loading="lazy" decoding="async">
      <p>QUATO DAN & AVA</p>
    </a>

    <a class="card" href="{{ route('projetos.show', 'quarto-catarina') }}">
      <img src="{{ asset('pingo-decor/assets/img/_mg_1415.jpg') }}" loading="lazy" decoding="async">
      <p>QUATO CATARINA</p>
    </a>

    
  </article>
  <div class="veja">
    <a href="{{ route('projetos.index') }}">Veja Mais</a>
  </div>
</section>