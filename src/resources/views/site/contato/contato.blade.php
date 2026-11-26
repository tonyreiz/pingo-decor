@extends('layout.site')
@section('title', 'Contato | Pingo Decor')
@section('content')

@include('site.contato.banner')


    @if (session('sucesso'))
    <div class="sucesso">
      <p class="contato-sucesso" role="status">{{ session('sucesso') }}</p>
    </div>
    @endif
<section class="contato">
  
  <div class="card-proposta">


    <h2>Formulário</h2>

    <p>
      Para entrar em contato, receber informações ou resolver problemas ou dúvidas, acessos nessos meios de contato ou preencha o formulário abaixo.
    </p>

    <form class="formulario-contato" id="formulario-contato" action="{{ route('contato.enviar') }}" method="POST">
      @csrf
      <div class="campo-contato">
        <label for="nome">Nome completo</label>
        <input id="nome" name="nome" type="text" value="{{ old('nome') }}" maxlength="255" autocomplete="name" required>
        @error('nome')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="email">E-mail</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" required>
        @error('email')<small>{{ $message }}</small>@enderror
      </div>


      <div class="campo-contato">
        <label for="endereco">Endereço</label>
        <input id="endereco" name="endereco" type="text" value="{{ old('endereco') }}" maxlength="255" autocomplete="address-level2" required>
        @error('endereco')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="telefone">Telefone / WhatsApp</label>
        <input id="telefone" name="telefone" type="tel" value="{{ old('telefone') }}" maxlength="20" autocomplete="tel" required>
        @error('telefone')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="profissao">Profissão (opcional)</label>
        <input id="profissao" name="profissao" type="text" value="{{ old('profissao') }}" maxlength="255">
        @error('profissao')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="metragem">Metragem aproximada (m², opcional)</label>
        <input id="metragem" name="metragem" type="number" value="{{ old('metragem') }}" min="0" step="0.01">
        @error('metragem')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-duplo">

        <div class="campo-contato-meio">
          <label for="tipo_projeto">Tipo de projeto</label>
          <input id="tipo_projeto" name="tipo_projeto" type="text" value="{{ old('tipo_projeto') }}" maxlength="255" placeholder="Ex.: quarto infantil, brinquedoteca" required>
          @error('tipo_projeto')<small>{{ $message }}</small>@enderror
        </div>


        <div class="campo-contato-meio">
          <label for="prazo">Prazo desejado (opcional)</label>
          <input id="prazo" name="prazo" type="text" value="{{ old('prazo') }}" maxlength="255" placeholder="Ex.: 45 dias">
          @error('prazo')<small>{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="campo-contato-descricao">
        <label for="descricao">Conte um pouco sobre o projeto (opcional)</label>
        <textarea id="descricao" name="descricao" rows="4" maxlength="10000">{{ old('descricao') }}</textarea>
        @error('descricao')<small>{{ $message }}</small>@enderror
      </div>

    </form>


  </div>
  <section class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58503.74394477931!2d-46.66374115!3d-23.586969!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5be2ddc5cca9%3A0x6c55ac641a4e4e86!2sPingo%20Decor!5e0!3m2!1spt-BR!2sbr!4v1795544807368!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>

    <button type="submit" form="formulario-contato">Enviar solicitação</button>
  </section>

</section>
<script>
  const descricaoProjeto = document.getElementById('descricao');

  if (descricaoProjeto) {
    const linhasIniciais = 4;
    const caracteresPorLinhaExtra = 100;

    const ajustarAlturaDescricao = () => {
      descricaoProjeto.rows = linhasIniciais + Math.floor(
        descricaoProjeto.value.length / caracteresPorLinhaExtra
      );
    };

    descricaoProjeto.addEventListener('input', ajustarAlturaDescricao);
    ajustarAlturaDescricao();
  }
</script>
@endsection
