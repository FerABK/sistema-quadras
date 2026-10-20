<?php

namespace App\Http\Controllers;

use App\Models\Quadra;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Bloqueio;

class ReservaController extends Controller
{
    public function index()
    {
        $consulta = Reserva::with('quadra', 'pagamentos')->orderByDesc('data_reserva');

        if (!auth()->user()->isAdmin()) {
            $consulta->where('user_id', auth()->id());
        }

        return view('reservas.index', [
            'reservas' => $consulta->get(),
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->query('data', today()->toDateString());
        $quadraId = $request->query('quadra_id');
        $ocupados = [];

        if ($quadraId && $data) {
            $ocupados = Reserva::where('quadra_id', $quadraId)
                ->whereDate('data_reserva', $data)
                ->pluck('hora_inicio')
                ->map(function ($hora) {
                    return (int) $hora;
                })
                ->all();
        }

        return view('reservas.create', [
            'quadras' => Quadra::orderBy('nome')->get(),
            'data' => $data,
            'quadraId' => $quadraId,
            'ocupados' => $ocupados,
            'horarios' => range(5, 21),
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'quadra_id' => ['required', 'integer', 'exists:quadras,id'],
            'data_reserva' => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['required', 'integer', Rule::in(range(5, 21))],
            'metodo_pagamento' => ['required', Rule::in(['dinheiro', 'debito', 'credito'])],
            'tipo_pagamento' => ['nullable', Rule::in(['avista', 'parcelado'])],
            'parcelas' => ['nullable', 'integer', 'min:1', 'max:6'],
        ]);
        
        if (Bloqueio::where('quadra_id', $request->quadra_id)
            ->whereDate('data', $request->data_reserva)
            ->exists()) {
            return back()
                ->withErrors(['data_reserva' => 'Esta quadra está bloqueada nesta data.'])
                ->withInput();
        }
        

        $quadra = Quadra::findOrFail($dados['quadra_id']);
        $hora = (int) $dados['hora_inicio'];

        $horarioOcupado = Reserva::where('quadra_id', $quadra->id)
            ->whereDate('data_reserva', $dados['data_reserva'])
            ->where('hora_inicio', $hora)
            ->exists();

        if ($horarioOcupado) {
            return back()
                ->withInput()
                ->withErrors([
                    'hora_inicio' => 'Esse horário acabou de ser reservado. Escolha outro.',
                ]);
        }

        $metodo = $dados['metodo_pagamento'];
        $tipo = null;
        $parcelas = 1;

        if ($metodo === 'credito') {
            $tipo = $dados['tipo_pagamento'] ?? 'avista';

            if ($tipo === 'parcelado') {
                $parcelas = (int) ($dados['parcelas'] ?? 1);
            }
        }

        $total = (float) $quadra->valor_hora;

        DB::transaction(function () use (
            $dados, $quadra, $hora, $metodo, $tipo, $parcelas, $total
        ) {
            $reserva = Reserva::create([
                'user_id' => auth()->id(),
                'quadra_id' => $quadra->id,
                'data_reserva' => $dados['data_reserva'],
                'hora_inicio' => $hora,
                'hora_fim' => $hora + 1,
                'horas_total' => 1,
                'total' => $total,
                'condicao_pagamento' => $metodo,
                'metodo_pagamento' => $metodo,
                'tipo_pagamento' => $tipo,
                'parcelas' => $parcelas,
            ]);

            for ($i = 1; $i <= $parcelas; $i++) {
                $reserva->pagamentos()->create([
                    'numero_parcela' => $i,
                    'valor' => round($total / $parcelas, 2),
                    'vencimento' => now()->addMonths($i - 1)->toDateString(),
                ]);
            }
        });

        return redirect()
            ->route('reservas.index')
            ->with('sucesso', 'Reserva realizada com sucesso.');
    }

    public function destroy(Reserva $reserva)
    {
        if (!auth()->user()->isAdmin() && $reserva->user_id !== auth()->id()) {
            abort(403);
        }

        $reserva->delete();

        return redirect()
            ->route('reservas.index')
            ->with('sucesso', 'Reserva excluída.');
    }
}
