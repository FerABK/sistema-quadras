<?php

namespace App\Http\Controllers;

use App\Models\Quadra;
use App\Models\Reserva;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usuarioId = auth()->id();

        $totalQuadras = Quadra::count();
        $minhasReservas = Reserva::where('user_id', $usuarioId)->count();
        $totalReservas = Reserva::count();

        $proximasReservas = Reserva::with('quadra')
            ->where('user_id', $usuarioId)
            ->whereDate('data_reserva', '>=', today())
            ->orderBy('data_reserva')
            ->orderBy('hora_inicio')
            ->take(5)
            ->get();

        return view('dashboard', [
            'totalQuadras' => $totalQuadras,
            'minhasReservas' => $minhasReservas,
            'totalReservas' => $totalReservas,
            'proximasReservas' => $proximasReservas,
        ]);
    }
}
