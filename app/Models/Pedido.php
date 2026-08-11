<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    const CREATED_AT = 'criado_em';

    const UPDATED_AT = null;

    protected $fillable = ['id_cliente', 'id_endereco', 'status', 'valor', 'confirmado_em', 'enviado_em'];

    protected $casts = [
    'valor' => 'decimal:2',
    'criado_em' => 'datetime', 'confirmado_em' => 'datetime', 'enviado_em' => 'datetime',
    ];

    public function Cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function Endereco() {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }

    public function Pagamento() {
        return $this->hasMany(Pagamento::class, 'id_pedido');
    }

    public function itens() {
        return $this->hasMany(ProdutoPedido::class, 'id_pedido');
    }

    public function Extrato() {
        return $this->hasMany(Extrato::class, 'id_pedido');
    }
}
