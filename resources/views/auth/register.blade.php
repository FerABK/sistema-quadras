@extends('layouts.app')

@section('title', 'Criar conta')

@section('content')
    <div class="card auth-card">
        <h1 class="h1">Criar conta</h1>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <label for="name">Nome</label>
            <input class="form-control" id="name" name="name">

            <label for="login">Login</label>
            <input class="form-control" id="login" name="login">

            <label for="password">Senha</label>
            <input class="form-control" id="password" type="password" name="password">

            <label for="password_confirmation">Confirmar senha</label>
            <input class="form-control" id="password_confirmation" type="password" name="password_confirmation">

            <div class="actions">
                <button class="btn" type="submit">Cadastrar</button>
                <a class="btn light" href="{{ route('login') }}">Já tenho conta</a>
            </div>
        </form>
    </div>
@endsection
