<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->get();

        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    public function create()
    {
        return view('usuarios.form', ['usuario' => new User()]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'login' => ['required', 'string', 'max:50', 'unique:users,login'],
            'role' => ['required', Rule::in(['cliente', 'administrador'])],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $dados['name'],
            'login' => $dados['login'],
            'role' => $dados['role'],
            'password' => Hash::make($dados['password']),
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('sucesso', 'Usuário cadastrado.');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.form', ['usuario' => $usuario]);
    }

    public function update(Request $request, User $usuario)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'login' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'login')->ignore($usuario->id),
            ],
            'role' => ['required', Rule::in(['cliente', 'administrador'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $usuario->name = $dados['name'];
        $usuario->login = $dados['login'];
        $usuario->role = $dados['role'];

        if (!empty($dados['password'])) {
            $usuario->password = Hash::make($dados['password']);
        }

        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with('sucesso', 'Usuário atualizado.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('erro', 'Você não pode excluir seu próprio usuário.');
        }

        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('sucesso', 'Usuário excluído.');
    }
}