@extends('layout.site')

@section('title', 'Pingo Decor | Home')

@section('content')

    @include('site.home.banner')

    @include('site.home.apresentacao')

    @include('site.home.destaques')

    @include('site.home.projetos')

    @include('site.home.chamada-projetos')
    
    @include('site.home.depoimento')

@endsection
