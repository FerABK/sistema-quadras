<div class="card">
    <form method="POST" action="{{ $bloqueio->exists
        ? route('bloqueios.update', $bloqueio)
        : route('bloqueios.store') }}">

        @csrf

        @if ($bloqueio->exists)
            @method('PUT')
        @endif

        <label for="quadra_id">Quadra</label>
        <select class="form-control" id="quadra_id" name="quadra_id" required>
            <option value="">Selecione uma quadra</option>

            @foreach ($quadras as $quadra)
                <option value="{{ $quadra->id }}"
                    @selected(old('quadra_id', $bloqueio->quadra_id) == $quadra->id)>
                    {{ $quadra->nome }}
                </option>
            @endforeach
        </select>

        <label for="data">Data</label>
        <input class="form-control" id="data" type="date" name="data"
               value="{{ old('data', $bloqueio->data?->format('Y-m-d')) }}"
               required>

        <label for="motivo">Motivo</label>
        <input class="form-control" id="motivo" type="text" name="motivo"
               value="{{ old('motivo', $bloqueio->motivo) }}"
               maxlength="255" required>

        @if ($errors->any())
            <p>{{ $errors->first() }}</p>
        @endif

        <button class="btn" type="submit">Salvar</button>
        <a class="btn secondary" href="{{ route('bloqueios.index') }}">
            Cancelar
        </a>
    </form>
</div>
