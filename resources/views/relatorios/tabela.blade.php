@extends('layouts.app')

@section('title', $titulo)

@section('content')
    <h1 class="h1">{{ $titulo }}</h1>

    <div class="card">
        <div style="overflow-x: auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Quadra</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Horas</th>
                        <th>Total</th>
                        <th>Pagamento</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reservas as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->usuario->name }}</td>
                            <td>{{ $r->quadra->nome }}</td>
                            <td>{{ $r->data_reserva->format('d/m/Y') }}</td>
                            <td>{{ sprintf('%02d:00 - %02d:00', $r->hora_inicio, $r->hora_fim) }}</td>
                            <td>{{ $r->horas_total }}</td>
                            <td>R$ {{ number_format($r->total, 2, ',', '.') }}</td>
                            <td>{{ $r->condicao_pagamento }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Nenhuma reserva encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a class="btn light" href="{{ route('relatorios.index') }}">Voltar aos relatórios</a>
@endsection