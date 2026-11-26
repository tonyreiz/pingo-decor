@php
  $bannerPadrao = 'pingo-decor/assets/img/bannerPingoDecor.png';
  $caminhoBanner = isset($bannerPrincipal)
    ? 'pingo-decor/assets/' . ltrim($bannerPrincipal->imagem_banner, '/')
    : $bannerPadrao;
  $imagemBanner = file_exists(public_path($caminhoBanner)) ? $caminhoBanner : $bannerPadrao;
@endphp

<section
  class="banner"
  aria-label="{{ $bannerPrincipal->titulo_banner ?? 'Pingo Decor' }}"
  style="background-image: url('{{ asset($imagemBanner) }}');"
></section>
