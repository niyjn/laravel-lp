<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Exceptions\ProdutoComPedidosVinculadosException;
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
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'=>'required|string|max:255',
            'descricao'=>'required|string|max:255',
            'preco'=>'required|numeric|min:0',
            'ativo'=>'sometimes|boolean'
        ]);

        $produtos = Produto::create([
            'nome' => $dados['nome'],
            'descricao' => $dados['descricao'],
            'preco' => $dados['preco'],
            'ativo' => $dados['ativo'] ?? false
        ]);

        return redirect()->back();
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
        return view('produtos.edit', compact('produto'));
    }


    public function update(Request $request, Produto $produto)
    {

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:255'],
            'preco' => ['required', 'numeric', 'min:0'],
        ]);

        // Checkbox desmarcado não é enviado pelo navegador; boolean() o transforma em false.
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
        if ($produto->itensPedido()->exists()) {
                throw new ProdutoComPedidosVinculadosException;
        }

        $produto->delete();

        return redirect()->route('produtos.index');
    }
}
