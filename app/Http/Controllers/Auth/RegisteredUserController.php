<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'login' => ['required', 'string', 'max:50', 'unique:users,login'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $dados['role'] = 'cliente';

        $usuario = User::create($dados);

        Auth::login($usuario);

        return redirect()->route('dashboard');
    }
}
