<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AdminPedidoController,
    ClienteController,
    EnderecoController,
    PedidoController,
    ProdutoController
};

// Landing page / vitrine publica
Route::get('/', [ProdutoController::class, 'landing'])->name('home');

// Breeze Authentication Routes
require __DIR__.'/auth.php';

// Rotas autenticadas genericas (Perfil e Enderecos)
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ClienteController::class, 'profile'])
        ->name('perfil');

    Route::patch('/perfil', [ClienteController::class, 'update'])
        ->name('perfil.update');

    // Enderecos (protegidos por auth e policies)
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

    // Pedidos do cliente
    Route::get('/pedidos', [PedidoController::class, 'index'])
        ->name('pedidos.index');

    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])
        ->name('pedidos.show');
});

// Gestao Operacional de Pedidos (Acesso para Admin e Gerente)
Route::middleware(['auth', 'role:admin,gerente'])->group(function () {
    Route::get('/admin/pedidos', [AdminPedidoController::class, 'index'])
        ->name('admin.pedidos.index');

    Route::get('/admin/pedidos/{pedido}', [AdminPedidoController::class, 'show'])
        ->name('admin.pedidos.show');

    Route::patch('/admin/pedidos/{pedido}/status', [AdminPedidoController::class, 'updateStatus'])
        ->name('admin.pedidos.status.update');
});

// Gestao de Produtos (Acesso exclusivo para Administrador)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/produtos/create', [ProdutoController::class, 'create'])
        ->name('produtos.create');

    Route::post('/produtos', [ProdutoController::class, 'store'])
        ->name('produtos.store');

    Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])
        ->name('produtos.edit');

    Route::patch('/produtos/{produto}', [ProdutoController::class, 'update'])
        ->name('produtos.update');

    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])
        ->name('produtos.destroy');
});

// Catalogo de produtos publico
Route::get('/produtos', [ProdutoController::class, 'index'])
    ->name('produtos.index');

Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])
    ->name('produtos.show');

// Checkout e criacao de pedidos
Route::get('/checkout', [PedidoController::class, 'create'])
    ->middleware('auth')
    ->name('checkout');

Route::post('/pedidos', [PedidoController::class, 'store'])
    ->middleware('auth')
    ->name('pedidos.store');
