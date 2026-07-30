<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamento';

    public $timestamps = false;

    protected $fillable = ['metodo', 'status', 'pago_em'];

    public function Pedidos() {
        return this->belongsTo(Pedido::class, 'id_pedido');
    }

}
