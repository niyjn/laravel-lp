<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoPedido extends Model
{
    protected $table = "produto_pedido";
    public $timestamps = false;

    protected $fillable = ['id_pedido', 'id_produto', 'quantidade', 'preco_unitario', 'observacao'];

    protected $casts = ['preco_unitario' => 'decimal:2', 'quantidade' => 'integer'];

    public function pedido()  { return $this->belongsTo(Pedido::class,  'id_pedido'); }
    public function produto() { return $this->belongsTo(Produto::class, 'id_produto'); }
}
