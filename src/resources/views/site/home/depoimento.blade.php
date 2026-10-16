<section class="depoimento wow animate__animated animate__fadeInDown">

    <div class="roleta">

        @foreach($listaDepoimento as $lista)
            <div class="descricao">
                @if($lista->cliente)
                    <img src="{{ asset('pingo-decor/assets/cliente/' .  $lista->cliente->foto_cliente) }}" alt="Foto de {{ $lista->cliente->nome_cliente }}">
                @endif
    
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
