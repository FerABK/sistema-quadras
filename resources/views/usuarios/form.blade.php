@extends('layouts.app')

@section('title', $usuario->exists ? 'Editar usuário' : 'Novo usuário')

@section('content')
    <div class="card">
        <h1 class="h1">
            {{ $usuario->exists ? 'Editar usuário' : 'Novo usuário' }}
        </h1>

        <form method="POST"
              action="{{ $usuario->exists ? route('usuarios.update', $usuario) : route('usuarios.store') }}">

            @csrf

            @if ($usuario->exists)
                @method('PUT')
            @endif

            <label for="name">Nome</label>
            <input class="form-control" id="name" name="name"
                   value="{{ old('name', $usuario->name) }}" required>

            <label for="login">Login</label>
            <input class="form-control" id="login" name="login"
                   value="{{ old('login', $usuario->login) }}" required>

            <label for="role">Função</label>
            <select class="form-control" id="role" name="role" required>
                <option value="cliente"
                    @selected(old('role', $usuario->role ?: 'cliente') === 'cliente')>
                    Cliente
                </option>

                <option value="administrador"
                    @selected(old('role', $usuario->role) === 'administrador')>
                    Administrador
                </option>
            </select>

            <label for="password">
                {{ $usuario->exists ? 'Nova senha (deixe em branco para manter)' : 'Senha' }}
            </label>

            <input class="form-control" id="password" type="password" name="password"
                   {{ $usuario->exists ? '' : 'required' }} >

            <div class="actions">
                <button class="btn" type="submit">Salvar</button>
                <a class="btn light" href="{{ route('usuarios.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection