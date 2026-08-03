<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extrato extends Model
{
    protected $table = 'extrato';
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = NULL;

    protected $fillable = ['id_pedido', 'descricao'];
    protected $casts = ['criado_em' => 'datetime'];

    public function pedido() {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }


}
