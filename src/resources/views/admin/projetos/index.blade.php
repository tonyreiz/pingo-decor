@extends('layout.admin')


@section('eyebrow', 'GESTÃO DE PROJETOS')
@section('heading', 'Projetos')
@section('description', 'Crie, edite e delete as suas projetos.')

@section('actions')
    <button
        type="button"
        class="admin-primary-btn"
        data-admin-modal-open="modalCriarProjetos"
        aria-haspopup="dialog"
    >+ Novo projeto</button>
@endsection

@section('content')
    @include('admin.projetos.listarProjetos')
@endsection
