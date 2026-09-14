<?php

namespace App\Http\Controllers;

use App\Exceptions\ProdutoComPedidosVinculadosException;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produtos.index', [
            'produtos' => Produto::where('ativo', true)->get(),
        ]);
    }

    public function landing()
    {
        $produtos = Produto::where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view('landing', compact('produtos'));
    }

    public function create()
    {
        $this->authorize('create', Produto::class);

        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Produto::class);

        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'ativo' => 'sometimes|boolean',
        ]);

        $produto = Produto::create([
            'nome' => $dados['nome'],
            'descricao' => $dados['descricao'],
            'preco' => $dados['preco'],
            'ativo' => $dados['ativo'] ?? false,
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso.');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        $this->authorize('update', $produto);

        return view('produtos.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        $this->authorize('update', $produto);

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:255'],
            'preco' => ['required', 'numeric', 'min:0'],
        ]);

        $dados['ativo'] = $request->boolean('ativo');

        $produto->update($dados);

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $this->authorize('delete', $produto);

        if ($produto->itensPedido()->exists()) {
            throw new ProdutoComPedidosVinculadosException;
        }

        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto exclu?do com sucesso.');
    }
}
