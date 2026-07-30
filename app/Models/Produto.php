<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produto';
    public $timestamps = false;

    protected $fillable = ['nome', 'descricao', 'preco', 'ativo'];
    protected $casts = ['preco' => 'decimal:2'];

    public function itensPedido() {
        return $this->hasMany(ProdutoPedido::class, 'id_produto');
    }
}
