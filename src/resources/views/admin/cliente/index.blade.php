@extends('layout.admin')

@section('actions')
    <button
        type="button"
        class="admin-primary-btn"
        data-admin-modal-open="modalCriarCliente"
        aria-haspopup="dialog"
    >+ Novo cliente</button>
@endsection

@section('content')
    @include('admin.cliente.listarCliente')
@endsection
