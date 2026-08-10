<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



use App\Http\Controllers\{
    ClienteController,
    EnderecoController,
    ExtratoController,
    PagamentoController,
    PedidoController,
    ProdutoController,
    ProdutoPedidoController,
    AuthController
};


Route::get('/', [ProdutoController::class, 'landing'])->name('home');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// login

Route::get('/login', [AuthController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

Route::middleware('auth')->group(function() {
    Route::get('/perfil', [ClienteController::class, 'profile'])
             ->name('perfil');

         Route::patch('/perfil', [ClienteController::class, 'update'])
             ->name('perfil.update');

         Route::post('/logout', [AuthController::class, 'destroy'])
             ->name('logout');

        //endereco
        Route::get('/clientes/{cliente}/endereco', [EnderecoController::class, 'index']);
        Route::post('/clientes/{cliente}/endereco', [EnderecoController::class, 'store']);
        Route::patch('/endereco/{endereco}', [EnderecoController::class, 'update']);
        Route::delete('/endereco/{endereco}', [EnderecoController::class, 'destroy']);

        //pedido
        Route::get('/pedidos/{pedido}', [PedidoController::class, 'show']);
        Route::get('/pedidos', [PedidoController::class, 'index']);
        Route::post('/pedidos/', [PedidoController::class, 'store']);
        Route::patch('/pedidos/{pedido}', [PedidoController::class, 'update']);

        //item
        Route::post('/pedidos/{pedido}/itens', [ProdutoPedidoController::class, 'store']);
        Route::patch('/item-pedido/{item}', [ProdutoPedidoController::class, 'update']);
        Route::delete('/item-pedido/{item}', [ProdutoPedidoController::class, 'destroy']);

        //pagamento
        Route::post('/pedidos/{pedido}/pagamento', [PagamentoController::class, 'store']);
        Route::get('/pedidos/{pedido}/pagamento', [PagamentoController::class, 'show']);
        Route::patch('/pedidos/{pedido}/pagamento', [PagamentoController::class, 'update']);

        //extrato
        Route::get('/pedidos/{pedido}/extrato', [ExtratoController::class, 'show']);
        Route::get('/pedidos/extrato', [ExtratoController::class, 'index']);

});

Route::middleware(['auth', 'can:gerenciar-produtos'])->group(function() {
    // Produtos Admin
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::patch('/produtos/{produto}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy']);
});

// Produtos user
Route::get('/produtos', [ProdutoController::class, 'index']);
Route::get('/produtos/{produto}', [ProdutoController::class, 'show']);
