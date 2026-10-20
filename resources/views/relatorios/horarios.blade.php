@extends('layouts.app')

@section('title', 'Horários mais usados')

@section('content')
    <h1 class="h1">Horários mais usados</h1>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Horário</th>
                    <th>Total de reservas</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($dados as $linha)
                    <tr>
                        <td>
                            {{ sprintf('%02d:00 - %02d:00', $linha->hora_inicio, $linha->hora_inicio + 1) }}
                        </td>
                        <td>{{ $linha->quantidade }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Sem reservas cadastradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection