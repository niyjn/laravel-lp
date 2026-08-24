<?php

use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\ProdutoPedido;
use Illuminate\Support\Facades\Hash;

function criarCliente(string $email, bool $admin = false): Cliente
{
    $cliente = Cliente::create([
        'nome' => 'Cliente de teste',
        'email' => $email,
        'senha_hash' => Hash::make('senha-segura'),
    ]);

    $cliente->is_admin = $admin;
    $cliente->save();

    return $cliente;
}

function criarEndereco(Cliente $cliente): Endereco
{
    return $cliente->enderecos()->create([
        'logradouro' => 'Rua das Flores',
        'numero' => '123',
        'bairro' => 'Centro',
        'cidade' => 'Guarapuava',
        'estado' => 'PR',
        'cep' => '85010-000',
    ]);
}

test('a customer cannot access another customers order', function () {
    $clienteA = criarCliente('a@example.com');
    $clienteB = criarCliente('b@example.com');
    $enderecoB = criarEndereco($clienteB);

    $pedido = Pedido::create([
        'id_cliente' => $clienteB->id,
        'id_endereco' => $enderecoB->id,
        'status' => 'aguardando_confirmacao',
        'valor' => 10,
    ]);

    $this->actingAs($clienteA)
        ->get(route('pedidos.show', $pedido))
        ->assertForbidden();
});

test('a regular customer cannot update a product', function () {
    $cliente = criarCliente('cliente@example.com');
    $produto = Produto::create([
        'nome' => 'X-Burger',
        'descricao' => 'Lanche de teste',
        'preco' => 20,
        'ativo' => true,
    ]);

    $this->actingAs($cliente)
        ->patch(route('produtos.update', $produto), [
            'nome' => 'Produto adulterado',
            'descricao' => 'Tentativa bloqueada',
            'preco' => 0,
        ])
        ->assertForbidden();
});

test('checkout uses the database price and creates order items', function () {
    $cliente = criarCliente('checkout@example.com');
    $endereco = criarEndereco($cliente);
    $produto = Produto::create([
        'nome' => 'X-Burger',
        'descricao' => 'Lanche de teste',
        'preco' => 19.90,
        'ativo' => true,
    ]);

    $response = $this->actingAs($cliente)
        ->post(route('pedidos.store'), [
            'endereco_id' => $endereco->id,
            'itens' => [[
                'produto_id' => $produto->id,
                'quantidade' => 2,
                'preco' => 0,
            ]],
        ]);

    $pedido = Pedido::firstOrFail();

    $response->assertRedirect(route('pedidos.show', $pedido));
    $this->assertDatabaseHas('pedido', [
        'id' => $pedido->id,
        'id_cliente' => $cliente->id,
        'id_endereco' => $endereco->id,
        'status' => 'aguardando_confirmacao',
        'valor' => 39.80,
    ]);
    $this->assertDatabaseHas('produto_pedido', [
        'id_pedido' => $pedido->id,
        'id_produto' => $produto->id,
        'quantidade' => 2,
        'preco_unitario' => 19.90,
    ]);
    expect(ProdutoPedido::count())->toBe(1);
});
