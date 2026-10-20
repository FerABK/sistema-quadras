@extends('layouts.app')

@section('title', 'Faturamento')

@section('content')
    <h1 class="h1">Relatório de faturamento</h1>

    <div class="card">
        <form method="GET" action="{{ route('relatorios.faturamento') }}">
            <div class="grid">
                <div>
                    <label for="inicio">Data inicial</label>
                    <input class="form-control" id="inicio" type="date"
                           name="inicio" value="{{ $inicio }}">
                </div>

                <div>
                    <label for="fim">Data final</label>
                    <input class="form-control" id="fim" type="date"
                           name="fim" value="{{ $fim }}">
                </div>
            </div>

            <button class="btn" type="submit">Filtrar</button>
            <a class="btn light" href="{{ route('relatorios.faturamento') }}">
                Todo o período
            </a>
        </form>
    </div>

    <div class="card">
        <p class="muted">Faturamento no período selecionado</p>
        <h2 class="h1">R$ {{ number_format($faturamento, 2, ',', '.') }}</h2>
    </div>
@endsection