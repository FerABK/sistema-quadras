@extends('layouts.app')

@section('title', 'Quadras')

@section('content')
    <div class="actions">
        <h1 class="h1">Quadras</h1>

        @if (auth()->user()->isAdmin())
            <a class="btn" href="{{ route('quadras.create') }}">Nova quadra</a>
        @endif
    </div>

    @if ($quadras->isEmpty())
        <div class="card">
            Nenhuma quadra cadastrada.
        </div>
    @else
        <div class="grid">
            @foreach ($quadras as $quadra)
                <div class="card">
                    @if ($quadra->imagem)
                        <img class="quadra-img" 
                            src="{{ asset('storage/quadras/' . $quadra->imagem) }}" alt="{{ $quadra->nome }}">
                    @endif

                    <h2 class="h2">{{ $quadra->nome }}</h2>

                    <p>{{ $quadra->tipo ?: 'Modalidade não informada' }}</p>

                    <p>
                        R$ {{ number_format($quadra->valor_hora, 2, ',', '.') }} / hora
                    </p>

                    <div class="actions">
                        <a class="btn"
                           href="{{ route('reservas.create', ['quadra_id' => $quadra->id, 'data' => today()->toDateString()]) }}">
                            Reservar
                        </a>

                        @if (auth()->user()->isAdmin())
                            <a class="btn secondary"
                               href="{{ route('quadras.edit', $quadra) }}">
                                Editar
                            </a>

                            <form method="POST"
                                  action="{{ route('quadras.destroy', $quadra) }}"
                                  onsubmit="return confirm('Excluir esta quadra?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn danger" type="submit">
                                    Excluir
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection