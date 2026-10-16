@extends('layout.admin')

@section('actions')
    <button
        type="button"
        class="admin-primary-btn"
        data-admin-modal-open="modalCriarContato"
        aria-haspopup="dialog"
    >+ Novo contato</button>
@endsection

@section('content')
    @include('admin.contato.listarContato')
@endsection
