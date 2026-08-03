<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }


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

        return redirect()->route('perfil');
    }


    public function register()
    {
        return view('auth.register');
    }


    public function storeRegister(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:cliente,email'],
            'senha' => ['required', 'min:6', 'confirmed'],
        ]);

        $cliente = Cliente::create([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'senha_hash' => Hash::make($dados['senha']),
        ]);

        Auth::login($cliente);

        $request->session()->regenerate();

        return redirect()->route('perfil');
    }


    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}