<?php

namespace App\Http\Controllers;

use App\Models\Quadra;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios.index');
    }

    public function todas()
    {
        $reservas = Reserva::with(['usuario', 'quadra'])
            ->orderBy('data_reserva')
            ->orderBy('hora_inicio')
            ->get();

        return view('relatorios.tabela', [
            'titulo' => 'Todas as reservas',
            'reservas' => $reservas,
        ]);
    }

    public function porData(Request $request)
    {
        $request->validate([
            'data' => ['nullable', 'date'],
        ]);

        $reservas = collect();

        if ($request->filled('data')) {
            $reservas = Reserva::with(['usuario', 'quadra'])
                ->whereDate('data_reserva', $request->data)
                ->orderBy('hora_inicio')
                ->get();
        }

        return view('relatorios.filtro-data', [
            'reservas' => $reservas,
        ]);
    }

    public function faturamento(Request $request)
    {
        $request->validate([
            'inicio' => ['nullable', 'date'],
            'fim' => ['nullable', 'date', 'after_or_equal:inicio'],
        ]);

        $consulta = Reserva::query();

        if ($request->filled('inicio')) {
            $consulta->whereDate('data_reserva', '>=', $request->inicio);
        }

        if ($request->filled('fim')) {
            $consulta->whereDate('data_reserva', '<=', $request->fim);
        }

        return view('relatorios.faturamento', [
            'faturamento' => $consulta->sum('total'),
            'inicio' => $request->inicio,
            'fim' => $request->fim,
        ]);
    }

    public function horarios()
    {
        $dados = Reserva::select('hora_inicio',DB::raw('COUNT(*) as quantidade'))
            ->groupBy('hora_inicio')
            ->orderByDesc('quantidade')
            ->get();

        return view('relatorios.horarios', [
            'dados' => $dados,
        ]);
    }

    public function quadrasMaisUsadas()
    {
        $dados = Quadra::query()
            ->leftJoin('reservas', 'quadras.id', '=', 'reservas.quadra_id')
            ->select(
                'quadras.nome',
                DB::raw('COUNT(reservas.id) as total_reservas')
            )
            ->groupBy('quadras.id', 'quadras.nome')
            ->orderByDesc('total_reservas')
            ->get();

        return view('relatorios.quadras-mais-usadas', [
            'dados' => $dados,
        ]);
    }
}
