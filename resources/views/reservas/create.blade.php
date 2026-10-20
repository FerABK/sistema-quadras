@extends('layouts.app')

@section('title', 'Nova reserva')

@section('content')
    <div class="card">
        <h1 class="h1">Fazer reserva</h1>

        <form method="GET" action="{{ route('reservas.create') }}">
            <label for="quadra_id_busca">Quadra</label>

            <select class="form-control" id="quadra_id_busca" name="quadra_id" required>
                <option value="">Selecione</option>

                @foreach ($quadras as $quadra)
                    <option value="{{ $quadra->id }}"
                        @selected((string) $quadraId === (string) $quadra->id)>
                        {{ $quadra->nome }} — R$ {{ number_format($quadra->valor_hora, 2, ',', '.') }}/h
                    </option>
                @endforeach
            </select>

            <label for="data">Data</label>
            <input class="form-control" id="data" type="date" name="data" 
                   min="{{ today()->toDateString() }}" value="{{ $data }}" required>

            <button class="btn secondary" type="submit">Verificar horários</button>
        </form>

        @if ($quadraId && $quadras->contains('id', (int) $quadraId))
            <hr style="margin: 22px 0">

            <h2 class="h2">Escolha horário e pagamento</h2>

            <form method="POST" action="{{ route('reservas.store') }}">
                @csrf

                <input type="hidden" name="quadra_id" value="{{ $quadraId }}">
                <input type="hidden" name="data_reserva" value="{{ $data }}">

                <label for="hora_inicio">Horários disponíveis</label>

                <select class="form-control" id="hora_inicio" name="hora_inicio" required>
                    <option value="">Selecione um horário</option>

                    @foreach ($horarios as $hora)
                        @if (!in_array($hora, $ocupados))
                            <option value="{{ $hora }}" @selected(old('hora_inicio') == $hora)>
                                {{ sprintf('%02d:00 - %02d:00', $hora, $hora + 1) }}
                            </option>
                        @endif
                    @endforeach
                </select>

                @if (count($ocupados) === count($horarios))
                    <p class="muted">Não há horários disponíveis nessa data.</p>
                @endif

                <label for="metodo_pagamento">Forma de pagamento</label>

                <select class="form-control" id="metodo_pagamento" name="metodo_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="dinheiro">Dinheiro</option>
                    <option value="debito">Débito</option>
                    <option value="credito">Crédito</option>
                </select>

                <div id="credito" style="display: none">
                    <label for="tipo_pagamento">Crédito</label>

                    <select class="form-control" id="tipo_pagamento" name="tipo_pagamento">
                        <option value="avista">À vista</option>
                        <option value="parcelado">Parcelado</option>
                    </select>

                    <div id="parcelas_div" style="display: none">
                        <label for="parcelas">Número de parcelas</label>
                        <input class="form-control" type="number" id="parcelas"
                               name="parcelas" min="1" max="6" value="1">
                    </div>
                </div>

                <div class="actions">
                    <button class="btn" type="submit">Confirmar reserva</button>
                    <a class="btn light" href="{{ route('reservas.index') }}">Cancelar</a>
                </div>
            </form>
        @endif
    </div>

    <script>
        const metodo = document.getElementById('metodo_pagamento');
        const credito = document.getElementById('credito');
        const tipo = document.getElementById('tipo_pagamento');
        const parcelas = document.getElementById('parcelas_div');

        function atualizar() {
            if (metodo) {
                credito.style.display = metodo.value === 'credito' ? 'block' : 'none';

                parcelas.style.display = metodo.value === 'credito' && tipo.value === 'parcelado' ? 'block' : 'none';
            }
        }

        if (metodo) {
            metodo.addEventListener('change', atualizar);
            tipo.addEventListener('change', atualizar);
            atualizar();
        }
    </script>
@endsection