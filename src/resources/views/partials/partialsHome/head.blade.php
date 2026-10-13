<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Pingo Decor: arquitetura e interiores infantis com afeto, funcionalidade e identidade.">
<meta property="og:title" content="Pingo Decor">
<meta property="og:description" content="Projetos de arquitetura e interiores infantis personalizados.">
<meta property="og:type" content="website">
<title>@yield('title', 'Pingo Decor')</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('pingo-decor/assets/logo.svg') }}">
<link rel="stylesheet" href="{{ asset('pingo-decor/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('pingo-decor/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('pingo-decor/css/responsivo.css') }}">
@unless (request()->routeIs('publicacoes'))
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endunless
