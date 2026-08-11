<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function store(Request $request)
    {
        $dados = $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required'],
        ]);

        $autenticou = Auth::attempt([
            'email' => $dados['email'],
            'password' => $dados['senha'],
        ]);

        if (! $autenticou) {
            return back()
                ->withErrors(['email' => 'Email ou senha inválidos.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('perfil'));
    }

    public function create() {
        return view('auth.login');
    }

    public function destroy(Request $request) {
         Auth::guard('web')->logout();

         $request->session()->invalidate();

         $request->session()->regenerateToken();

         return redirect('/');
    }

}
