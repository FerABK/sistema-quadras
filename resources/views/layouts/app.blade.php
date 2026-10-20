<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SistemaQuadras')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="topbar">
        <div class="inner">
            @auth
                <a class="brand" href="{{ route('dashboard') }}">SistemaQuadras</a>
            @else
                <a class="brand" href="{{ route('login') }}">SistemaQuadras</a>
            @endauth

            @auth
                <a href="{{ route('quadras.index') }}">Quadras</a>
                <a href="{{ route('reservas.index') }}">Minhas reservas</a>
                <a href="{{ route('avaliacoes.index') }}">Avaliações</a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('usuarios.index') }}">Usuários</a>
                    <a href="{{ route('relatorios.index') }}">Relatórios</a>
                    <a href="{{ route('bloqueios.index') }}">Bloqueios</a>

                @endif

                <span>{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="btn danger" type="submit">Sair</button>
                </form>
            @endauth
        </div>
    </header>

    <main class="container">
        @if (session('sucesso'))
            <div class="alert">{{ session('sucesso') }}</div>
        @endif

        @if (session('erro'))
            <div class="alert error">{{ session('erro') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <strong>Confira os dados informados:</strong>

                <ul>
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>