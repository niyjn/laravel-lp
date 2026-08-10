<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function create() {
        return view('clientes.create');
    }
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:cliente,email',
            'senha' => 'required|min:6'
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

    public function show(Cliente $cliente) {
        return view('clientes.profile', compact('cliente'));
    }

    public function update(Request $request) {
        $cliente = $request->user();

        $dados = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'string', 'email',
            Rule::unique('cliente', 'email')->ignore($cliente->id)],
            'senha' => 'sometimes|nullable|string|min:6|confirmed',
        ]);

        if($request->filled('senha')) {
            $dados['senha_hash'] = Hash::make($dados['senha']);
        }

        unset($dados['senha']);

        $cliente->update($dados);

        return redirect()->back();
    }

    public function profile(Request $request) {
            return view('clientes.profile', [
                'cliente' => $request->user(),
            ]);
    }
}
