@extends('layout.admin')

@section('actions')
    <button
        type="button"
        class="admin-primary-btn"
        data-admin-modal-open="modalCriarBanner"
        aria-haspopup="dialog"
    >+ Novo banner</button>
@endsection

@section('content')
    @include('admin.banner.listaBanner')
@endsection