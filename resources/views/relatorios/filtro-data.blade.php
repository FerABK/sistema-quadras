@extends('layouts.app')

@section('title', 'Reservas por data')

@section('content')
    <h1 class="h1">Reservas por data</h1>

    <div class="card">
        <form method="GET" action="{{ route('relatorios.data') }}">
            <label for="data">Data</label>
            <input class="form-control" id="data" type="date"
                   name="data" value="{{ request('data') }}">

            <button class="btn" type="submit">Filtrar</button>
        </form>
    </div>

    @if (request()->filled('data'))
        @include('relatorios.tabela-corpo', ['reservas' => $reservas])
    @endif
@endsection