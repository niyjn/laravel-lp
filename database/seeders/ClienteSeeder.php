<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('12345678');

        // 1. Administrador (Acesso total: produtos, pedidos, relatorios)
        Cliente::updateOrCreate(
            ['email' => 'admin@bahalanches.com'],
            [
                'nome' => 'Administrador Baha',
                'senha_hash' => $password,
                'role' => 'admin',
                'is_admin' => true,
            ]
        );

        // 2. Gerente (Acesso operacional: gestao de pedidos e status)
        Cliente::updateOrCreate(
            ['email' => 'gerente@bahalanches.com'],
            [
                'nome' => 'Gerente Baha',
                'senha_hash' => $password,
                'role' => 'gerente',
                'is_admin' => false,
            ]
        );

        // 3. Usuario / Cliente comum (Fazer pedidos, cardapio, enderecos)
        Cliente::updateOrCreate(
            ['email' => 'usuario@bahalanches.com'],
            [
                'nome' => 'Cliente Teste',
                'senha_hash' => $password,
                'role' => 'usuario',
                'is_admin' => false,
            ]
        );
    }
}
