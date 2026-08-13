<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
      {
          return view('pedidos.index', [
              'pedidos' => $request->user()
                  ->pedidos()
                  ->orderByDesc('criado_em')
                  ->get(),
          ]);
      }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('pedidos.checkout', ['enderecos' => $request->user()->enderecos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'endereco_id' => ['required', 'integer'],

            'itens' => ['required', 'array', 'min:1'],
            'itens.*.produto_id' => [
                'required',
                'integer',
                'distinct',
                'exists:produto,id',
            ],
            'itens.*.quantidade' => ['required', 'integer', 'min:1', 'max:99'],
            'itens.*.observacao' => ['nullable', 'string', 'max:150'],
        ]);

        $cliente = $request->user();

        $pedido = DB::transaction(function () use ($cliente, $dados) {

                  $endereco = $cliente->enderecos()
                      ->findOrFail($dados['endereco_id']);

                  // Cria o "cabeçalho" do pedido.
                  $pedido = Pedido::create([
                      'id_cliente' => $cliente->id,
                      'id_endereco' => $endereco->id,
                      'status' => 'aguardando_confirmacao',
                      'valor' => 0,
                  ]);

                  $valorTotal = 0;

                  foreach ($dados['itens'] as $item) {
                      // Preço oficial vem do banco.
                      $produto = Produto::where('ativo', true)
                          ->find($item['produto_id']);

                      if (! $produto) {
                          throw ValidationException::withMessages([
                              'itens' => 'Um dos produtos não está mais disponível.',
                          ]);
                      }

                      $quantidade = $item['quantidade'];
                      $precoUnitario = $produto->preco;
                      $subtotal = round($precoUnitario * $quantidade, 2);


                      $pedido->itens()->create([
                          'id_produto' => $produto->id,
                          'quantidade' => $quantidade,
                          'preco_unitario' => $precoUnitario,
                          'observacao' => $item['observacao'] ?? null,
                      ]);

                      $valorTotal += $subtotal;
                  }

                  $pedido->update([
                      'valor' => $valorTotal,
                  ]);

                  return $pedido;
              });

              return redirect()
                  ->route('pedidos.show', $pedido)
                  ->with('success', "Pedido #{$pedido->id} criado com sucesso.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Pedido $pedido)
    {
        abort_unless(
                  $pedido->id_cliente === $request->user()->id,
                  403,
              );

        $pedido->load(['itens.produto', 'endereco']);

        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pedido $pedido)
    {
        //
    }
}
