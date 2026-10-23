@extends('layout.admin')

@section('title', 'Agendamentos | Painel Pingo Decor')
@section('navtitle', 'Agendamentos')
@section('eyebrow', 'GESTÃO DE ATENDIMENTOS')
@section('heading', 'Agendamentos')
@section('description', 'Consulte e cadastre os agendamentos de clientes.')

@section('content')
    @include('admin.agendamento.listarAgendamento')
@endsection
