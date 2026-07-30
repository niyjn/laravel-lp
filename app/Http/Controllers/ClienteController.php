<?php

namespace App\Http\Controllers;

use App\Models\Clique;

class CliqueController extends Controller
{
    public function store()
    {
        Clique::create([
            'botao' => 'pedir',
            'data_hora' => now(),
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}