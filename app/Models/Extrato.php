<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Extrato extends Model
{
    protected $table = 'extrato';
    const CREATED_AT = 'criado_em';
    const UPDATE_AT = NULL;

    protected $fillable = ['id_pedido', 'descricao'];
    protected $cast = ['criado_em' => 'datetime'];

    public function pedidos() {
        return this->belongsTo(Pedido::class, 'id_pedido');
    }


}
