@extends('layout.site')
@section('title', 'Contato | Pingo Decor')
@section('content')
<section class="contato">

  <div class="card-proposta">

    <div class="icone">
      <i class="fa-regular fa-clipboard"></i>
    </div>

    <h2>Quero receber <br> uma proposta</h2>

    <p>
      Preencha o formulário e receba uma proposta personalizada para o seu projeto
    </p>

    @if (session('sucesso'))
      <p class="contato-sucesso" role="status">{{ session('sucesso') }}</p>
    @endif

    <form class="formulario-contato" action="{{ route('contato.enviar') }}" method="POST">
      @csrf
      <div class="campo-contato">
        <label for="nome">Nome completo</label>
        <input id="nome" name="nome" type="text" value="{{ old('nome') }}" maxlength="255" autocomplete="name" required>
        @error('nome')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="telefone">Telefone / WhatsApp</label>
        <input id="telefone" name="telefone" type="tel" value="{{ old('telefone') }}" maxlength="20" autocomplete="tel" required>
        @error('telefone')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="email">E-mail</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" required>
        @error('email')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="endereco">Cidade e bairro do projeto</label>
        <input id="endereco" name="endereco" type="text" value="{{ old('endereco') }}" maxlength="255" autocomplete="address-level2" required>
        @error('endereco')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="profissao">Profissão (opcional)</label>
        <input id="profissao" name="profissao" type="text" value="{{ old('profissao') }}" maxlength="255">
        @error('profissao')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="tipo_projeto">Tipo de projeto</label>
        <input id="tipo_projeto" name="tipo_projeto" type="text" value="{{ old('tipo_projeto') }}" maxlength="255" placeholder="Ex.: quarto infantil, brinquedoteca" required>
        @error('tipo_projeto')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="metragem">Metragem aproximada (m², opcional)</label>
        <input id="metragem" name="metragem" type="number" value="{{ old('metragem') }}" min="0" step="0.01">
        @error('metragem')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="prazo">Prazo desejado (opcional)</label>
        <input id="prazo" name="prazo" type="text" value="{{ old('prazo') }}" maxlength="255">
        @error('prazo')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="descricao">Conte um pouco sobre o projeto (opcional)</label>
        <textarea id="descricao" name="descricao" rows="4">{{ old('descricao') }}</textarea>
        @error('descricao')<small>{{ $message }}</small>@enderror
      </div>

      <div class="campo-contato">
        <label for="observacoes">Observações (opcional)</label>
        <textarea id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
        @error('observacoes')<small>{{ $message }}</small>@enderror
      </div>

      <button type="submit">Enviar solicitação</button>
    </form>

  </div>

</section>
@endsection
