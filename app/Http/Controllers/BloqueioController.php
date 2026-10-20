<?php

namespace App\Http\Controllers;

use App\Models\Bloqueio;
use App\Models\Quadra;
use Illuminate\Http\Request;

class BloqueioController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $bloqueios = Bloqueio::with('quadra')
            ->orderByDesc('data')
            ->get();

        return view('bloqueios.index', compact('bloqueios'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $quadras = Quadra::all();

        return view('bloqueios.create', compact('quadras'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $dados = $request->validate([
            'quadra_id' => ['required', 'exists:quadras,id'],
            'data' => ['required', 'date'],
            'motivo' => ['required', 'string', 'max:255'],
        ]);

        Bloqueio::create($dados);

        return redirect()->route('bloqueios.index');
    }

    public function edit(Bloqueio $bloqueio)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $quadras = Quadra::all();

        return view('bloqueios.edit', compact('bloqueio', 'quadras'));
    }

    public function update(Request $request, Bloqueio $bloqueio)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $dados = $request->validate([
            'quadra_id' => ['required', 'exists:quadras,id'],
            'data' => ['required', 'date'],
            'motivo' => ['required', 'string', 'max:255'],
        ]);

        $bloqueio->update($dados);

        return redirect()->route('bloqueios.index');
    }

    public function destroy(Bloqueio $bloqueio)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $bloqueio->delete();

        return redirect()->route('bloqueios.index');
    }
}