<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Pedido::class);

        $status = $request->query('status');

        $pedidos = Pedido::with(['cliente', 'endereco', 'itens.produto'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByDesc('criado_em')
            ->paginate(15);

        return view('admin.pedidos.index', compact('pedidos', 'status'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $this->authorize('view', $pedido);

        $pedido->load(['cliente', 'endereco', 'itens.produto']);

        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Pedido $pedido)
    {
        $this->authorize('updateStatus', $pedido);

        $dados = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'aguardando_confirmacao',
                    'em_preparo',
                    'enviado',
                    'entregue',
                    'cancelado',
                ]),
            ],
        ]);

        $status = $dados['status'];

        $updates = ['status' => $status];

        if ($status === 'em_preparo' && ! $pedido->confirmado_em) {
            $updates['confirmado_em'] = now();
        } elseif ($status === 'enviado' && ! $pedido->enviado_em) {
            $updates['enviado_em'] = now();
        }

        $pedido->update($updates);

        return redirect()
            ->route('admin.pedidos.show', $pedido)
            ->with('success', "Status do pedido atualizado para '{$status}'.");
    }
}
