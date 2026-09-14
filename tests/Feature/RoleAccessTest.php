<?php

use App\Models\Cliente;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Support\Facades\Hash;

function criarUsuarioPorRole(string $role, string $email): Cliente
{
    return Cliente::create([
        'nome' => "Usuario {$role}",
        'email' => $email,
        'senha_hash' => Hash::make('12345678'),
        'role' => $role,
        'is_admin' => ($role === 'admin'),
    ]);
}

test('guest is redirected to login on protected routes', function () {
    $this->get(route('perfil'))->assertRedirect(route('login'));
    $this->get(route('admin.pedidos.index'))->assertRedirect(route('login'));
    $this->get(route('produtos.create'))->assertRedirect(route('login'));
});

test('admin can access admin orders and create new products', function () {
    $admin = criarUsuarioPorRole('admin', 'admin_role_test@bahalanches.com');

    $this->actingAs($admin)
        ->get(route('admin.pedidos.index'))
        ->assertSuccessful();

    $this->actingAs($admin)
        ->get(route('produtos.create'))
        ->assertSuccessful();

    $this->actingAs($admin)
        ->post(route('produtos.store'), [
            'nome' => 'Burger Especial Teste',
            'descricao' => 'Delicioso burger artesanal com molho secreto',
            'preco' => 35.00,
            'ativo' => true,
        ])
        ->assertRedirect(route('produtos.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('produto', [
        'nome' => 'Burger Especial Teste',
    ]);
});

test('gerente can manage orders but cannot create or edit products', function () {
    $gerente = criarUsuarioPorRole('gerente', 'gerente_role_test@bahalanches.com');
    $cliente = criarUsuarioPorRole('usuario', 'cliente_role_test@bahalanches.com');
    $endereco = $cliente->enderecos()->create([
        'logradouro' => 'Rua das Palmeiras',
        'numero' => '456',
        'bairro' => 'Batel',
        'cidade' => 'Guarapuava',
        'estado' => 'PR',
        'cep' => '85015-000',
    ]);

    $pedido = Pedido::create([
        'id_cliente' => $cliente->id,
        'id_endereco' => $endereco->id,
        'status' => 'aguardando_confirmacao',
        'valor' => 50.00,
    ]);

    // 1. Gerente can access order panel
    $this->actingAs($gerente)
        ->get(route('admin.pedidos.index'))
        ->assertSuccessful();

    // 2. Gerente can update order status
    $this->actingAs($gerente)
        ->patch(route('admin.pedidos.status.update', $pedido), [
            'status' => 'em_preparo',
        ])
        ->assertRedirect(route('admin.pedidos.show', $pedido));

    $this->assertDatabaseHas('pedido', [
        'id' => $pedido->id,
        'status' => 'em_preparo',
    ]);

    // 3. Gerente CANNOT access product creation (Forbidden 403)
    $this->actingAs($gerente)
        ->get(route('produtos.create'))
        ->assertForbidden();

    $this->actingAs($gerente)
        ->post(route('produtos.store'), [
            'nome' => 'Burger Proibido',
            'descricao' => 'Tentativa nao autorizada',
            'preco' => 20.00,
        ])
        ->assertForbidden();
});

test('regular customer cannot access admin panel or update other customers addresses', function () {
    $usuario1 = criarUsuarioPorRole('usuario', 'user1_test@bahalanches.com');
    $usuario2 = criarUsuarioPorRole('usuario', 'user2_test@bahalanches.com');

    $endereco1 = $usuario1->enderecos()->create([
        'logradouro' => 'Rua Um',
        'numero' => '10',
        'bairro' => 'Centro',
        'cidade' => 'Guarapuava',
        'estado' => 'PR',
        'cep' => '85010-000',
    ]);

    // 1. Regular user cannot access /admin/pedidos
    $this->actingAs($usuario1)
        ->get(route('admin.pedidos.index'))
        ->assertForbidden();

    // 2. Regular user cannot access /produtos/create
    $this->actingAs($usuario1)
        ->get(route('produtos.create'))
        ->assertForbidden();

    // 3. Regular user cannot edit another customer address (EnderecoPolicy)
    $this->actingAs($usuario2)
        ->get(route('enderecos.edit', $endereco1))
        ->assertForbidden();

    $this->actingAs($usuario2)
        ->delete(route('enderecos.destroy', $endereco1))
        ->assertForbidden();
});
