@extends('layout.admin')

@section('title', 'Funcionários | Painel Pingo Decor')
@section('navtitle', 'Funcionários')
@section('eyebrow', 'GESTÃO DE CONTEÚDO')
@section('heading', 'Funcionários')
@section('description', 'Gerencie os funcionários cadastrados no sistema.')

@section('actions')
    <button
        type="button"
        class="admin-primary-btn"
        data-admin-modal-open="modalCriarFuncionario"
        aria-haspopup="dialog"
    >+ Novo funcionário</button>
@endsection

@section('content')
    @include('admin.funcionario.listarFuncionario')
@endsection
