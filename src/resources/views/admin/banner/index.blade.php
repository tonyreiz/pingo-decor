@extends('layout.admin')

@section('eyebrow', 'GESTÃO DO BANNER')
@section('heading', 'Banners')
@section('description', 'Crie, delete e edite os banners do site.')


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