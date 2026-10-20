<?php

namespace App\Http\Controllers;

use App\Models\Quadra;
use Illuminate\Http\Request;

class QuadraController extends Controller
{
    public function index()
    {
        $quadras = Quadra::orderBy('nome')->get();

        return view('quadras.index', ['quadras' => $quadras]);
    }

    public function create()
    {
        return view('quadras.form', ['quadra' => new Quadra()]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'tipo' => ['nullable', 'string', 'max:50'],
            'valor_hora' => ['required', 'numeric', 'min:0.01'],
            'imagem' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('imagem')) {
            $nomeImagem = time() . '_' . $request->file('imagem')->getClientOriginalName();

            $request->file('imagem')->move(
                public_path('storage/quadras'),
                $nomeImagem
            );

            $dados['imagem'] = $nomeImagem;
        }

        Quadra::create($dados);

        return redirect()
            ->route('quadras.index')
            ->with('sucesso', 'Quadra cadastrada.');
    }

    public function edit(Quadra $quadra)
    {
        return view('quadras.form', ['quadra' => $quadra]);
    }

    public function update(Request $request, Quadra $quadra)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'tipo' => ['nullable', 'string', 'max:50'],
            'valor_hora' => ['required', 'numeric', 'min:0.01'],
            'imagem' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('imagem')) {
            if ($quadra->imagem) {
                $caminho = public_path('storage/quadras/' . $quadra->imagem);

                if (file_exists($caminho)) {
                    unlink($caminho);
                }
            }

            $nomeImagem = time() . '_' . $request->file('imagem')->getClientOriginalName();

            $request->file('imagem')->move(
                public_path('storage/quadras'),
                $nomeImagem
            );

            $dados['imagem'] = $nomeImagem;
        }

        $quadra->update($dados);

        return redirect()
            ->route('quadras.index')
            ->with('sucesso', 'Quadra atualizada.');
    }

    public function destroy(Quadra $quadra)
    {
        if ($quadra->reservas()->exists()) {
            return back()->with(
                'erro',
                'Não é possível excluir uma quadra que possui reservas.'
            );
        }

        if ($quadra->imagem) {
            $caminho = public_path('storage/quadras/' . $quadra->imagem);

            if (file_exists($caminho)) {
                unlink($caminho);
            }
        }

        $quadra->delete();

        return redirect()
            ->route('quadras.index')
            ->with('sucesso', 'Quadra excluída.');
    }
}
