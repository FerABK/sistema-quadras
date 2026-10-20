@extends('layouts.app')

@section('title', 'Bloqueios')

@section('content')
    <div class="actions">
        <h1 class="h1">Bloqueios</h1>

        <a class="btn" href="{{ route('bloqueios.create') }}">
            Novo bloqueio
        </a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Quadra</th>
                    <th>Data</th>
                    <th>Motivo</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($bloqueios as $bloqueio)
                    <tr>
                        <td>{{ $bloqueio->quadra->nome }}</td>
                        <td>{{ $bloqueio->data->format('d/m/Y') }}</td>
                        <td>{{ $bloqueio->motivo }}</td>
                        <td>
                            <a class="btn secondary"
                               href="{{ route('bloqueios.edit', $bloqueio) }}">
                                Editar
                            </a>

                            <form method="POST"
                                  action="{{ route('bloqueios.destroy', $bloqueio) }}"
                                  onsubmit="return confirm('Excluir este bloqueio?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn danger" type="submit">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Nenhum bloqueio cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection