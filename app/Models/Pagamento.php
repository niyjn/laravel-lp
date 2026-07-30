<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamento';

    protected $fillable = ['id_pedido', 'metodo', 'status', 'pago_em'];
    protected $casts = ['pago_em' => 'datetime'];

    public function Pedido() {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

}
