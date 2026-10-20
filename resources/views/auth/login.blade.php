@extends('layouts.app')

@section('title', 'Entrar')

@section('content')
    <div class="card auth-card">
        <h1 class="h1">Entrar</h1>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="login">Login</label>
            <input class="form-control" id="login" name="login" required autofocus>

            <label for="password">Senha</label>
            <input class="form-control" id="password" type="password" name="password" required>

            <label>
                <input type="checkbox" name="remember" value="1">
                Lembrar de mim
            </label>

            <div class="actions" style="margin-top: 18px">
                <button class="btn" type="submit">Entrar</button>
                <a class="btn light" href="{{ route('register') }}">Criar conta</a>
            </div>
        </form>
    </div>
@endsection
