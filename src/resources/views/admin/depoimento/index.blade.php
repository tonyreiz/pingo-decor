@extends('layout.admin')

@section('title', 'Depoimentos | Painel Pingo Decor')
@section('navtitle', 'Depoimentos')
@section('eyebrow', 'GESTÃO DE CONTEÚDO')
@section('heading', 'Depoimentos')
@section('description', 'Consulte os depoimentos dos clientes e gerencie sua publicação no site.')

@section('content')
    @include('admin.depoimento.listarDepoimento')
@endsection
