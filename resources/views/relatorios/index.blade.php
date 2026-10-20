@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
    <h1 class="h1">Relatórios</h1>

    <div class="grid">
        <a class="card" href="{{ route('relatorios.todas') }}">
            <h2 class="h2">Todas as reservas</h2>
            <p class="muted">Listagem geral das reservas.</p>
        </a> 

        <a class="card" href="{{ route('relatorios.data') }}">
            <h2 class="h2">Reservas por data</h2>
            <p class="muted">Filtre as reservas por dia.</p>
        </a>

        <a class="card" href="{{ route('relatorios.faturamento') }}">
            <h2 class="h2">Faturamento</h2>
            <p class="muted">Faturamento total ou por período.</p>
        </a>

        <a class="card" href="{{ route('relatorios.horarios') }}">
            <h2 class="h2">Horários mais usados</h2>
            <p class="muted">Quantidade de reservas por hora de início.</p>
        </a>

        <a class="card" href="{{ route('relatorios.quadras-mais-usadas') }}">
            <h2 class="h2">Quadras mais usadas</h2>
            <p class="muted">Ranking de utilização.</p>
        </a>

    </div>
@endsection