@extends('layout.admin')

@section('eyebrow', 'GESTÃO DE PUBLICAÇÕES')
@section('heading', 'Publicações')
@section('description', 'Crie, edite e delete as suas publicações.')


@section('actions')
    <button
        type="button"
        class="admin-primary-btn"
        data-admin-modal-open="modalCriarPublicacao"
        aria-haspopup="dialog"
    >+ Nova publicação</button>
@endsection

@section('content')
    @include('admin.publicacoes.listarPublicacoes')
@endsection
