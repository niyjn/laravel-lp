<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnderecoRequest;
use App\Http\Requests\UpdateEnderecoRequest;
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

    public function store(StoreEnderecoRequest $request)
    {
        $request->user()->enderecos()->create($request->validated());

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

    public function update(UpdateEnderecoRequest $request, Endereco $endereco)
    {
        $endereco->update($request->validated());

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
