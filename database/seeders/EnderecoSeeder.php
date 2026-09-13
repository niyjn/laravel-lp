<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Endereco;
use Illuminate\Database\Seeder;

class EnderecoSeeder extends Seeder
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

        Endereco::updateOrCreate(
            [
                'id_cliente' => $cliente->id,
                'logradouro' => 'Rua XV de Novembro',
                'numero' => '750',
            ],
            [
                'bairro' => 'Centro',
                'cidade' => 'Guarapuava',
                'estado' => 'PR',
                'cep' => '85010-000',
                'complemento' => 'Apto 402',
            ]
        );

        Endereco::updateOrCreate(
            [
                'id_cliente' => $cliente->id,
                'logradouro' => 'Avenida Manoel Ribas',
                'numero' => '1420',
            ],
            [
                'bairro' => 'Bonsucesso',
                'cidade' => 'Guarapuava',
                'estado' => 'PR',
                'cep' => '85035-000',
                'complemento' => 'Sala 12',
            ]
        );
    }
}
