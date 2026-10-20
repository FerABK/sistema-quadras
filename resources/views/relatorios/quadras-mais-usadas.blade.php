@extends('layouts.app')

@section('title', 'Quadras mais usadas')

@section('content')
    <h1 class="h1">Quadras mais usadas</h1>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Quadra</th>
                    <th>Total de reservas</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($dados as $d)
                    <tr>
                        <td>{{ $d->nome }}</td>
                        <td>{{ $d->total_reservas }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Sem quadras.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection