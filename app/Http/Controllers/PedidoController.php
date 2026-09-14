<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $this->authorize('create', Pedido::class);

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

            $pedido = Pedido::create([
                'id_cliente' => $cliente->id,
                'id_endereco' => $endereco->id,
                'status' => 'aguardando_confirmacao',
                'valor' => 0,
            ]);

            $valorTotal = 0;

            foreach ($dados['itens'] as $item) {
                $produto = Produto::where('ativo', true)
                    ->find($item['produto_id']);

                if (! $produto) {
                    throw ValidationException::withMessages([
                        'itens' => 'Um dos produtos n?o est? mais dispon?vel.',
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
    public function show(Pedido $pedido)
    {
        $this->authorize('view', $pedido);

        $pedido->load(['itens.produto', 'endereco']);

        return view('pedidos.show', compact('pedido'));
    }
}
