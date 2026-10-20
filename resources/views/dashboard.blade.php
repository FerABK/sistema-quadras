@extends('layouts.app')

@section('title', 'Página inicial')

@section('content')
    <h1 class="h1">Bem-vindo, {{ auth()->user()->name }}!</h1>

    <div class="grid">
        <div class="card">
            <p class="muted">Quadras disponíveis</p>
            <div class="h1">{{ $totalQuadras }}</div>
            <a class="btn" href="{{ route('quadras.index') }}">Ver quadras</a>
        </div>

        <div class="card">
            @if (auth()->user()->isAdmin())
                <p class="muted">Reservas no sistema</p>
                <div class="h1">{{ $totalReservas }}</div>
            @else
                <p class="muted">Minhas reservas</p>
                <div class="h1">{{ $minhasReservas }}</div>
            @endif

            <a class="btn" href="{{ route('reservas.index') }}">Ver reservas</a>
        </div>

        <div class="card">
            <p class="muted">Acesso rápido</p>
            <a class="btn" href="{{ route('reservas.create') }}">Fazer uma reserva</a>
        </div>
    </div>

    <div class="card">
        <h2 class="h2">Próximas reservas</h2>

        @if ($proximasReservas->isEmpty())
            <p class="muted">Você ainda não tem reservas futuras.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Quadra</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($proximasReservas as $reserva)
                        <tr>
                            <td>{{ $reserva->data_reserva->format('d/m/Y') }}</td>
                            <td>{{ sprintf('%02d:00 - %02d:00', $reserva->hora_inicio, $reserva->hora_fim) }}</td>
                            <td>{{ $reserva->quadra->nome }}</td>
                            <td>R$ {{ number_format($reserva->total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if (auth()->user()->isAdmin())
        <div class="card">
            <h2 class="h2">Administração</h2>

            <div class="actions">
                <a class="btn" href="{{ route('quadras.create') }}">Cadastrar quadra</a>
                <a class="btn" href="{{ route('usuarios.index') }}">Gerenciar usuários</a>
                <a class="btn" href="{{ route('relatorios.index') }}">Abrir relatórios</a>
            </div>
        </div>
    @endif
@endsection