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

Route::middleware('guest')->group(function () {
      Route::get('/login', [AuthController::class, 'create'])
          ->name('login');

      Route::post('/login', [AuthController::class, 'store'])
          ->name('login.store');

      Route::get('/cadastro', [ClienteController::class, 'create'])
          ->name('register');

      Route::post('/cadastro', [ClienteController::class, 'store'])
          ->name('register.store');
  });

Route::middleware('auth')->group(function() {
    Route::get('/perfil', [ClienteController::class, 'profile'])
             ->name('perfil');

         Route::patch('/perfil', [ClienteController::class, 'update'])
             ->name('perfil.update');

         Route::post('/logout', [AuthController::class, 'destroy'])
             ->name('logout');

        //endereco
        Route::get('/enderecos', [EnderecoController::class, 'index'])
            ->name('enderecos.index');

        Route::get('/enderecos/novo', [EnderecoController::class, 'create'])
            ->name('enderecos.create');

        Route::post('/enderecos', [EnderecoController::class, 'store'])
            ->name('enderecos.store');

        Route::get('/enderecos/{endereco}/editar', [EnderecoController::class, 'edit'])
            ->name('enderecos.edit');

        Route::patch('/enderecos/{endereco}', [EnderecoController::class, 'update'])
            ->name('enderecos.update');

        Route::delete('/enderecos/{endereco}', [EnderecoController::class, 'destroy'])
            ->name('enderecos.destroy');

        //pedido
        Route::get('/pedidos/{pedido}', [PedidoController::class, 'show']);
        Route::get('/pedidos', [PedidoController::class, 'index']);
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
    Route::get('/produtos/create', [ProdutoController::class, 'create'])
        ->name('produtos.create');

    Route::post('/produtos', [ProdutoController::class, 'store'])
        ->name('produtos.store');

    Route::patch('/produtos/{produto}', [ProdutoController::class, 'update'])
        ->name('produtos.update');

    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])
        ->name('produtos.destroy');

    Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])
        -> name('produtos.edit');

});

// Produtos user
Route::get('/produtos', [ProdutoController::class, 'index'])
    ->name('produtos.index');

Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])
    ->name('produtos.show');

// Pedido & checkout

Route::get('/checkout', [PedidoController::class, 'create'])
          ->middleware('auth')
          ->name('checkout');

Route::post('/pedidos', [PedidoController::class, 'store'])
          ->middleware('auth')
          ->name('pedidos.store');
