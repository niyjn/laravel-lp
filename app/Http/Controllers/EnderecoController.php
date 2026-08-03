<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }


    public function store(Request $request)
    {

        $dados = $request->validate([
            'id_pedido' => 'required|integer',
            'logradouro' => 'required|string|max:60',
            'numero' => 'required|string|max:15',
            'bairro' => 'required|string|max:30',
            'cidade' => 'required|string|max:30',
            'estado' => 'required|string|max:30',
            'cep' => 'required|string|max:9',
            'complemento' => 'nullable|string|max:100'
        ]);

        $endereco = Endereco::create([
            'id_pedido' => $dados['id_pedido'],
            'logradouro' => $dados['logradouro'],
            'numero' => $dados['numero'],
            'bairro' => $dados['bairro'],
            'cidade' => $dados['cidade'],
            'estado' => $dados['estado'],
            'cep' => $dados['cep'],
            'complemento' => $dados['complemento']
        ]);

        return redirect()->route('home');
    }

    public function show(endereco $endereco)
    {
        return view('enderecos.show', compact('endereco'));
    }


    public function edit(endereco $endereco)
    {
        return view('enderecos.edit', compact('endereco'));
    }


    public function update(Request $request, endereco $endereco)
    {
        $dados = $request->validate([
            'logradouro' => 'required|string|max:60',
            'numero' => 'required|string|max:15',
            'bairro' => 'required|string|max:30',
            'cidade' => 'required|string|max:30',
            'estado' => 'required|string|max:30',
            'cep' => 'required|string|max:9',
            'complemento' => 'nullable|string|max:100',
        ]);

        $endereco->update($dados);

        return redirect()->back();
    }

    public function destroy(endereco $endereco)
    {
        $endereco->delete();

        return redirect()->route('home');
    }
}
