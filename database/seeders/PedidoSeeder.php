<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cliente = Cliente::where('email', 'usuario@bahalanches.com')->first();
        if (! $cliente) {
            return;
        }

        $endereco = $cliente->enderecos()->first();
        if (! $endereco) {
            return;
        }

        $burgers = Produto::where('ativo', true)->take(2)->get();
        if ($burgers->isEmpty()) {
            return;
        }

        // 1. Pedido aguardando confirmacao
        $pedido1 = Pedido::firstOrCreate(
            [
                'id_cliente' => $cliente->id,
                'id_endereco' => $endereco->id,
                'status' => 'aguardando_confirmacao',
            ],
            [
                'valor' => 0,
                'criado_em' => now()->subMinutes(25),
            ]
        );

        if ($pedido1->itens()->count() === 0) {
            $total = 0;
            foreach ($burgers as $b) {
                $pedido1->itens()->create([
                    'id_produto' => $b->id,
                    'quantidade' => 1,
                    'preco_unitario' => $b->preco,
                    'observacao' => 'Sem cebola',
                ]);
                $total += $b->preco;
            }
            $pedido1->update(['valor' => $total]);
        }

        // 2. Pedido entregue
        $pedido2 = Pedido::firstOrCreate(
            [
                'id_cliente' => $cliente->id,
                'id_endereco' => $endereco->id,
                'status' => 'entregue',
            ],
            [
                'valor' => 0,
                'criado_em' => now()->subHours(2),
                'confirmado_em' => now()->subHours(2)->addMinutes(5),
                'enviado_em' => now()->subHours(1)->addMinutes(30),
            ]
        );

        if ($pedido2->itens()->count() === 0) {
            $primeiro = $burgers->first();
            $pedido2->itens()->create([
                'id_produto' => $primeiro->id,
                'quantidade' => 2,
                'preco_unitario' => $primeiro->preco,
                'observacao' => 'Ponto da carne: ao ponto',
            ]);
            $pedido2->update(['valor' => $primeiro->preco * 2]);
        }
    }
}
