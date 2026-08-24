<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPedidoController extends Controller
{
    private const STATUS_VALIDOS = [
        'aguardando_confirmacao',
        'confirmado',
        'em_preparo',
        'enviado',
        'entregue',
        'cancelado',
    ];

    public function index()
    {
        return view('admin.pedidos.index', [
            'pedidos' => Pedido::with('cliente')
                ->orderByDesc('criado_em')
                ->get(),
        ]);
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'endereco', 'itens.produto']);

        return view('admin.pedidos.show', compact('pedido'));
    }

    public function updateStatus(Request $request, Pedido $pedido)
    {
        $dados = $request->validate([
            'status' => ['required', 'string', Rule::in(self::STATUS_VALIDOS)],
        ]);

        $atualizacoes = ['status' => $dados['status']];

        if ($dados['status'] === 'confirmado' && $pedido->confirmado_em === null) {
            $atualizacoes['confirmado_em'] = now();
        }

        if ($dados['status'] === 'enviado' && $pedido->enviado_em === null) {
            $atualizacoes['enviado_em'] = now();
        }

        $pedido->update($atualizacoes);

        return redirect()
            ->route('admin.pedidos.show', $pedido)
            ->with('success', 'Status do pedido atualizado com sucesso.');
    }
}
