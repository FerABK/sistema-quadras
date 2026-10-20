@extends('layouts.app')

@section('title', $avaliacao->exists ? 'Editar avaliação' : 'Nova avaliação')

@section('content')
    <div class="page-heading">
        <div>
            <h1 class="h1">{{ $avaliacao->exists ? 'Editar avaliação' : 'Nova avaliação' }}</h1>
            <p class="muted">Selecione uma quadra, dê uma nota e escreva seu comentário.</p>
        </div>
    </div>

    <div class="card evaluation-form-card">
        <form
            action="{{ $avaliacao->exists ? route('avaliacoes.update', $avaliacao) : route('avaliacoes.store') }}"
            method="POST"
            class="evaluation-form"
        >
            @csrf

            @if ($avaliacao->exists)
                @method('PUT')
            @endif

            <div>
                <label for="quadra_id">Quadra</label>

                <select id="quadra_id" name="quadra_id" class="form-control" required>
                    <option value="">Selecione uma quadra</option>

                    @foreach ($quadras as $quadra)
                        <option
                            value="{{ $quadra->id }}"
                            @selected(old('quadra_id', $avaliacao->quadra_id) == $quadra->id)
                        >
                            {{ $quadra->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="nota">Nota</label>

                <select id="nota" name="nota" class="form-control" required>
                    <option value="">Selecione uma nota</option>

                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" @selected(old('nota', $avaliacao->nota) == $i)>
                            {{ $i }} de 5
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="comentario">Comentário</label>

                <textarea
                    id="comentario"
                    name="comentario"
                    class="form-control"
                    rows="5"
                    maxlength="1000"
                    placeholder="Conte como foi sua experiência..."
                >{{ old('comentario', $avaliacao->comentario) }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn">
                    {{ $avaliacao->exists ? 'Salvar alterações' : 'Salvar avaliação' }}
                </button>

                <a href="{{ route('avaliacoes.index') }}" class="btn secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection