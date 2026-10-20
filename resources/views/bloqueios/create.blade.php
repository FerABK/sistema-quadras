@extends('layouts.app')

@section('title', 'Novo bloqueio')

@section('content')
    <h1 class="h1">Novo bloqueio</h1>

    @include('bloqueios.form', ['bloqueio' => new \App\Models\Bloqueio()])
@endsection