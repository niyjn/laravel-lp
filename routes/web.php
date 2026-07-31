<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ClienteController,
    EnderecoController,
    ExtratoController,
    PagamentoController,
    PedidoController,
    ProdutoController,
    ProdutoPedidoController
};


Route::inertia('/', 'Landing')->name('home');
