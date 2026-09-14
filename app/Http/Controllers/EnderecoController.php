<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('enderecos.index', [
            'enderecos' => $request->user()->enderecos,
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'logradouro' => 'required|string|max:60',
            'numero' => 'required|string|max:15',
            'bairro' => 'required|string|max:30',
            'cidade' => 'required|string|max:30',
            'estado' => 'required|string|max:30',
            'cep' => 'required|string|max:9',
            'complemento' => 'nullable|string|max:100'
        ]);

        $request->user()->enderecos()->create($dados);

        return redirect()
            ->route('enderecos.index')
            ->with('success', 'Endere?o cadastrado com sucesso.');
    }

    public function create()
    {
        return view('enderecos.create');
    }

    public function show(Endereco $endereco)
    {
        $this->authorize('view', $endereco);

        return view('enderecos.show', compact('endereco'));
    }

    public function edit(Endereco $endereco)
    {
        $this->authorize('update', $endereco);

        return view('enderecos.edit', compact('endereco'));
    }

    public function update(Request $request, Endereco $endereco)
    {
        $this->authorize('update', $endereco);

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

        return redirect()
            ->route('enderecos.index')
            ->with('success', 'Endere?o atualizado com sucesso.');
    }

    public function destroy(Endereco $endereco)
    {
        $this->authorize('delete', $endereco);

        $endereco->delete();

        return redirect()
            ->route('enderecos.index')
            ->with('success', 'Endere?o exclu?do com sucesso.');
    }
}
