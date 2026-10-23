@extends('layout.admin')

@section('title', 'Agendamentos | Painel Pingo Decor')
@section('navtitle', 'Agendamentos')
<<<<<<< HEAD
@section('eyebrow', 'GESTÃO DE ATENDIMENTOS')
@section('heading', 'Agendamentos')
@section('description', 'Consulte e cadastre os agendamentos de clientes.')

@section('content')
    @include('admin.agendamento.listarAgendamento')
@endsection
=======
@section('eyebrow', 'GESTÃO DE AGENDA')
@section('heading', 'Agendamentos')
@section('description', 'Acompanhe datas, horários, endereços e o andamento dos agendamentos.')

@section('actions')
    <button
        type="button"
        class="admin-primary-btn"
        data-admin-modal-open="modalNovoAgendamento"
        aria-haspopup="dialog"
    >+ Novo agendamento</button>
@endsection

@section('content')
    @include('admin.agendamento.listarAgendamento')
@endsection
>>>>>>> origin/main
