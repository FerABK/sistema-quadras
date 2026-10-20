@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
    <div class="actions" style="justify-content: space-between; align-items: center">
        <h1 class="h1">
            {{ auth()->user()->isAdmin() ? 'Todas as reservas' : 'Minhas reservas' }}
        </h1>

        <a class="btn" href="{{ route('reservas.create') }}">Nova reserva</a>
    </div>

    <div class="card">
        @if ($reservas->isEmpty())
            <p>Nenhuma reserva encontrada.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        @if (auth()->user()->isAdmin())
                            <th>Usuário</th>
                        @endif

                        <th>Quadra</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Pagamento</th>
                        <th>Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($reservas as $reserva)
                        <tr>
                            @if (auth()->user()->isAdmin())
                                <td>{{ $reserva->usuario->name }}</td>
                            @endif

                            <td>{{ $reserva->quadra->nome }}</td>
                            <td>{{ $reserva->data_reserva->format('d/m/Y') }}</td>
                            <td>
                                {{ sprintf('%02d:00 - %02d:00', $reserva->hora_inicio, $reserva->hora_fim) }}
                            </td>
                            <td>
                                {{ ucfirst($reserva->metodo_pagamento) }}
                                @if ($reserva->tipo_pagamento)
                                    ({{ $reserva->tipo_pagamento }})
                                @endif
                            </td>
                            <td>R$ {{ number_format($reserva->total, 2, ',', '.') }}</td>
                            <td>
                                <form method="POST"
                                      action="{{ route('reservas.destroy', $reserva) }}"
                                      onsubmit="return confirm('Excluir esta reserva?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn danger" type="submit">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection