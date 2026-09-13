<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produtos = [
            [
                'nome' => 'X-Baha Cl?ssico',
                'descricao' => 'P?o artesanal, burger 180g, queijo prato, bacon e maionese da casa.',
                'preco' => 32.90,
                'ativo' => true,
            ],
            [
                'nome' => 'Duplo Smash Burger',
                'descricao' => 'Dois burgers smash 90g, queijo cheddar duplo e cebola caramelizada.',
                'preco' => 36.50,
                'ativo' => true,
            ],
            [
                'nome' => 'Bacon Supreme',
                'descricao' => 'Burger 200g, muito bacon crocante, cheddar e molho barbecue artesanal.',
                'preco' => 38.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Frango Crispy Burger',
                'descricao' => 'Sobrecoxa empanada super crocante, alface americana e maionese verde.',
                'preco' => 28.50,
                'ativo' => true,
            ],
            [
                'nome' => 'Batata R?stica com Cheddar',
                'descricao' => 'Por??o generosa de batatas r?sticas com cheddar cremoso e bacon.',
                'preco' => 24.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Onion Rings Crocantes',
                'descricao' => 'An?is de cebola artesanais empanados servidos com molho da casa.',
                'preco' => 22.00,
                'ativo' => true,
            ],
            [
                'nome' => 'Refrigerante Lata 350ml',
                'descricao' => 'Coca-Cola, Guaran? Antarctica ou Sprite bem gelados.',
                'preco' => 6.50,
                'ativo' => true,
            ],
            [
                'nome' => 'Suco Natural de Laranja 500ml',
                'descricao' => 'Suco 100% integral da fruta preparado na hora.',
                'preco' => 9.00,
                'ativo' => true,
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::updateOrCreate(
                ['nome' => $produto['nome']],
                $produto
            );
        }
    }
}
