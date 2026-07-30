<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'endereco';

    protected $fillable = ['logradouro', 'numero', 'bairro', 'cidade', 'estado', 'cep', 'complemento'];

    public $timestamps = false;

    public function pedidos() {
        return $this->hasMany(Pedido::class, 'id_endereco');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

}
