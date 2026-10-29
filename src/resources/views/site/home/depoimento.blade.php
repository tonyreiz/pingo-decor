<section class="depoimento wow animate__animated animate__fadeInDown">

    <div class="roleta">



        @foreach($listaDepoimento as $lista)
        <div class="descricao">
            @if($lista->cliente)
            <img src="{{ asset('pingo-decor/assets/' .  $lista->cliente->foto_cliente) }}" alt="Foto de {{ $lista->cliente->nome_cliente }}">
            @endif

            @php

            $estrela = $lista->nota_depoimento;


            @endphp

            <ul class="nota">
                @for($i = 0; $i < $estrela; $i++)
         

                    <li class="estrela">
                    <img src="{{ asset('pingo-decor/assets/estrela.png') }}" alt="Nota do cliente">
                    </li>
         
                @endfor
            </ul>

            <h1>{{ $lista->titulo_depoimento ?: ($lista->cliente->nome_cliente ?? 'Depoimento de cliente') }}</h1>
            <p>{{ $lista->descricao_depoimento }}</p>
        </div>
        @endforeach
    </div>

    @if($listaDepoimento->count() > 1)
    <button class="depoimento-seta depoimento-anterior" type="button" aria-label="Depoimento anterior">
        &#10094;
    </button>
    <button class="depoimento-seta depoimento-proximo" type="button" aria-label="Próximo depoimento">
        &#10095;
    </button>
    @endif
</section>