<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Produtos user
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::get('/produtos/{produto}', [ProdutoController::class, 'show']);

// Produtos Admin
Route::post('/produtos', [ProdutoController::class, 'store']);
Route::patch('/produtos/{produto}', [ProdutoController::class, 'update']);
Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy']);

// Clientes
Route::post('/clientes', [ClienteController::class, 'store']);
Route::get('/clientes/{cliente}', [ClienteController::class, 'show']);
Route::patch('/clientes/{cliente}', [ClienteController::class, 'update']);


//Route::get('/me', [AuthController])
//Route::post('/login', [AuthController])
//Route::post('/logoff', [AuthController])

// Endereco

Route::get('/clientes/{cliente}/endereco', [EnderecoController::class, 'index']);
Route::post('/clientes/{cliente}/endereco', [EnderecoController::class, 'store']);
Route::patch('/endereco/{endereco}', [EnderecoController::class, 'update']);
Route::delete('/endereco/{endereco}', [EnderecoController::class, 'destroy']);

// Pedido

Route::get('/pedidos/{pedido}', [PedidoController::class, 'show']);
Route::get('/pedidos', [PedidoController::class, 'index']);
Route::post('/pedidos/', [PedidoController::class, 'store']);
Route::patch('/pedidos/{pedido}', [PedidoController::class, 'update']);

// Itens - patch (atualizar), post (criar ItemPedido), delete (apagarItem)

Route::post('/pedidos/{pedido}/itens', [ProdutoPedidoController::class, 'store']);
Route::patch('/item-pedido/{item}', [ProdutoPedidoController::class, 'update']);
Route::delete('/item-pedido/{item}', [ProdutoPedidoController::class, 'destroy']);


// Pagamentos - post & get

Route::post('/pedidos/{pedido}/pagamento', [PagamentoController::class, 'store']);
Route::get('/pedidos/{pedido}/pagamento', [PagamentoController::class, 'show']);
Route::patch('/pedidos/{pedido}/pagamento', [PagamentoController::class, 'update']);

// Extrato - ver

Route::get('/pedidos/{pedido}/extrato', [ExtratoController::class, 'show']);
Route::get('/pedidos/extrato', [ExtratoController::class, 'index']);
