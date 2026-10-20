@extends('layouts.app')

@section('title', 'Avaliações')

@section('content')
    <div class="page-heading">
        <div>
            <h1 class="h1">Avaliações</h1>
            <p class="muted">
                Consulte, cadastre e gerencie as avaliações das quadras.
            </p>
        </div>

        @if(!$avaliacoes->isEmpty())
            <a href="{{ route('avaliacoes.create') }}" class="btn">
                Nova avaliação
            </a>
        @endif
    </div>

    @forelse ($avaliacoes as $avaliacao)
        <div class="card evaluation-card">
            <div class="evaluation-header">
                <div>
                    <h2 class="h2">{{ $avaliacao->quadra->nome }}</h2>

                    @if (auth()->user()->isAdmin())
                        <p class="muted">
                            Avaliação de: {{ $avaliacao->usuario->name }}
                        </p>
                    @endif
                </div>

                <div class="evaluation-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $avaliacao->nota)
                            <span class="star filled">★</span>
                        @else
                            <span class="star">★</span>
                        @endif
                    @endfor

                    <strong>{{ $avaliacao->nota }}/5</strong>
                </div>
            </div>

            <div class="evaluation-comment">
                <strong>Comentário</strong>

                <p>{{ $avaliacao->comentario ?: 'Nenhum comentário foi informado.' }}</p>
            </div>

            <div class="evaluation-footer">
                <span class="muted">
                    Cadastrada em {{ $avaliacao->created_at->format('d/m/Y') }}
                </span>

                <div class="actions">
                    <a href="{{ route('avaliacoes.edit', $avaliacao) }}" class="btn secondary">
                        Editar
                    </a>

                    <form
                        action="{{ route('avaliacoes.destroy', $avaliacao) }}"
                        method="POST"
                        onsubmit="return confirm('Deseja realmente excluir esta avaliação?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn danger">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card empty-state">
            <h2 class="h2">Nenhuma avaliação cadastrada</h2>

            <p class="muted">
                Cadastre uma avaliação para ela aparecer nesta página.
            </p>

            <a href="{{ route('avaliacoes.create') }}" class="btn">
                Cadastrar avaliação
            </a>
        </div>
    @endforelse
@endsection