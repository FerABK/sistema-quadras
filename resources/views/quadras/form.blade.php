@extends('layouts.app')

@section('title', $quadra->exists ? 'Editar quadra' : 'Nova quadra')

@section('content')
    <div class="card">
        <h1 class="h1">
            {{ $quadra->exists ? 'Editar quadra' : 'Nova quadra' }}
        </h1>

        <form method="POST"
              enctype="multipart/form-data"
              action="{{ $quadra->exists ? route('quadras.update', $quadra) : route('quadras.store') }}">

            @csrf

            @if ($quadra->exists)
                @method('PUT')
            @endif

            <label for="nome">Nome</label>
            <input class="form-control" id="nome" name="nome"
                   value="{{ old('nome', $quadra->nome) }}" required>

            <label for="tipo">Modalidade</label>
            <input class="form-control" id="tipo" name="tipo"
                   value="{{ old('tipo', $quadra->tipo) }}"
                   placeholder="Futsal, vôlei, tênis...">

            <label for="valor_hora">Valor por hora (R$)</label>
            <input class="form-control" id="valor_hora" type="number"
                   name="valor_hora" min="0.01" step="0.01"
                   value="{{ old('valor_hora', $quadra->valor_hora) }}" required>

            <label for="imagem">Imagem</label>
            <input class="form-control" id="imagem" type="file"
                   name="imagem" accept="image/*">

            @if ($quadra->imagem)
                <img class="quadra-img"
                     src="{{ asset('storage/'.$quadra->imagem) }}"
                     alt="Imagem atual">
            @endif

            <div class="actions">
                <button class="btn" type="submit">Salvar</button>
                <a class="btn light" href="{{ route('quadras.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection