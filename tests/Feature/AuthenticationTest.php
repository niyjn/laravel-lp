<?php

use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

test('a customer can register and is authenticated', function () {
    $response = $this->post(route('register.store'), [
        'nome' => 'Maria Silva',
        'email' => 'maria@example.com',
        'senha' => 'senha-segura',
        'senha_confirmation' => 'senha-segura',
    ]);

    $cliente = Cliente::where('email', 'maria@example.com')->firstOrFail();

    $response->assertRedirect(route('perfil'));
    $this->assertAuthenticatedAs($cliente);
    expect(Hash::check('senha-segura', $cliente->senha_hash))->toBeTrue();
});

test('a customer can log in with the configured password column', function () {
    $cliente = Cliente::create([
        'nome' => 'João Silva',
        'email' => 'joao@example.com',
        'senha_hash' => Hash::make('senha-segura'),
    ]);

    $response = $this->post(route('login.store'), [
        'email' => $cliente->email,
        'senha' => 'senha-segura',
    ]);

    $response->assertRedirect(route('perfil'));
    $this->assertAuthenticatedAs($cliente);
});
