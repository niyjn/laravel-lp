<?php

namespace App\Http\Controllers;

use App\Models\Clique;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        $dados = request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:cliente,email',
            'senha' => 'required|min:6'
            ]);

        $cliente = Cliente::create([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'senha_hash' => Hash::make($dados['senha']),
        ]);

        return redirect()->route('home');
    }
}
