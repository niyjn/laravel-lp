<?php

namespace App\Models;

use Cassandra\Decimal;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';

    const CREATED_AT = 'criado_em';

    const UPDATED_AT = null;

    protected $fillable = ['id_cliente', 'id_endereco', 'status', 'valor', 'confirmado_em', 'enviado_em'];

    protected $cast = [
    'valor' => 'decimal:2',
    'criado_em' => 'datetime', 'confirmado_em' => 'datetime', 'enviado_em' => 'datetime',
    ];

    public function Clientes() {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function Enderecos() {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }

    public function Pagamentos() {
        return $this->hasMany(Pagamento::class, 'id_pedido');
    }

    public function Itens() {
        return $this->hasMany(ProdutoPedido::class, 'id_pedido');
    }

    public function Extratos() {
        return $this->hasMany(Extrato::class, 'id_pedido');
    }
}
