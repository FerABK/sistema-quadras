@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
    <div class="actions" style="justify-content: space-between; align-items: center">
        <h1 class="h1">Usuários</h1>
        <a class="btn" href="{{ route('usuarios.create') }}">Novo usuário</a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Função</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->login }}</td>
                        <td>{{ $usuario->role }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn secondary"
                                   href="{{ route('usuarios.edit', $usuario) }}">
                                    Editar
                                </a>

                                @if ($usuario->id !== auth()->id())
                                    <form method="POST"
                                          action="{{ route('usuarios.destroy', $usuario) }}"
                                          onsubmit="return confirm('Excluir usuário?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn danger" type="submit">Excluir</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection