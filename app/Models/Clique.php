<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clique extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'botao',
        'data_hora',
    ];
}