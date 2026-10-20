<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Quadra;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $avaliacoes = Avaliacao::with(['usuario', 'quadra'])
                ->orderByDesc('created_at')
                ->get();
        } else {
            $avaliacoes = Avaliacao::with(['usuario', 'quadra'])
                ->where('user_id', auth()->id())
                ->orderByDesc('created_at')
                ->get();
        }

        return view('avaliacoes.index', [
            'avaliacoes' => $avaliacoes,
        ]);
    }

    public function create()
    {
        $quadras = Quadra::orderBy('nome')->get();

        return view('avaliacoes.form', [
            'avaliacao' => new Avaliacao(),
            'quadras' => $quadras,
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'quadra_id' => ['required', 'integer', 'exists:quadras,id'],
            'nota' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:1000'],
        ]);

        $dados['user_id'] = auth()->id();

        Avaliacao::create($dados);

        return redirect()
            ->route('avaliacoes.index')
            ->with('sucesso', 'Avaliação cadastrada com sucesso.');
    }

    public function edit(Avaliacao $avaliacao)
    {
        $this->verificarPermissao($avaliacao);

        $quadras = Quadra::orderBy('nome')->get();

        return view('avaliacoes.form', [
            'avaliacao' => $avaliacao,
            'quadras' => $quadras,
        ]);
    }

    public function update(Request $request, Avaliacao $avaliacao)
    {
        $this->verificarPermissao($avaliacao);

        $dados = $request->validate([
            'quadra_id' => ['required', 'integer', 'exists:quadras,id'],
            'nota' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:1000'],
        ]);

        $avaliacao->update($dados);

        return redirect()
            ->route('avaliacoes.index')
            ->with('sucesso', 'Avaliação atualizada com sucesso.');
    }

    public function destroy(Avaliacao $avaliacao)
    {
        $this->verificarPermissao($avaliacao);

        $avaliacao->delete();

        return redirect()
            ->route('avaliacoes.index')
            ->with('sucesso', 'Avaliação excluída com sucesso.');
    }

    private function verificarPermissao(Avaliacao $avaliacao)
    {
        if (
            !auth()->user()->isAdmin()
            && $avaliacao->user_id != auth()->id()
        ) {
            abort(403);
        }
    }
}