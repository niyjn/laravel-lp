<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Creates the schema only for empty databases.
     *
     * The production Neon database predates Laravel migrations. The guards
     * make this migration safe to register there while allowing tests and new
     * installations to build the same singular-table schema from scratch.
     */
    public function up(): void
    {
        if (! Schema::hasTable('cliente')) {
            Schema::create('cliente', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('nome', 60);
                $table->string('email', 100);
                $table->string('senha_hash', 255);
                $table->timestamp('created_at')->nullable()->useCurrent();
            });
        }

        if (! Schema::hasTable('produto')) {
            Schema::create('produto', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('nome', 60);
                $table->string('descricao', 60);
                $table->decimal('preco', 10, 2);
                $table->boolean('ativo')->default(true);
            });
        }

        if (! Schema::hasTable('endereco')) {
            Schema::create('endereco', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('id_cliente');
                $table->string('logradouro', 60);
                $table->string('numero', 15);
                $table->string('bairro', 30);
                $table->string('cidade', 30);
                $table->string('estado', 30);
                $table->string('cep', 9);
                $table->string('complemento', 100)->nullable();

                $table->foreign('id_cliente', 'fk_cliente_endereco')
                    ->references('id')
                    ->on('cliente');
            });
        }

        if (! Schema::hasTable('pedido')) {
            Schema::create('pedido', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('id_endereco');
                $table->unsignedInteger('id_cliente');
                $table->string('status', 30)->nullable();
                $table->decimal('valor', 10, 2)->nullable();
                $table->timestamp('criado_em')->nullable()->useCurrent();
                $table->timestamp('confirmado_em')->nullable();
                $table->timestamp('enviado_em')->nullable();

                $table->foreign('id_cliente', 'fk_cliente_pedido')
                    ->references('id')
                    ->on('cliente');
                $table->foreign('id_endereco', 'fk_endereco_pedido')
                    ->references('id')
                    ->on('endereco');
            });
        }

        if (! Schema::hasTable('pagamento')) {
            Schema::create('pagamento', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('id_pedido');
                $table->string('metodo', 30)->nullable();
                $table->string('status', 30)->nullable();
                $table->timestamp('pago_em')->nullable()->useCurrent();

                $table->foreign('id_pedido', 'fk_pedido_pagamento')
                    ->references('id')
                    ->on('pedido');
            });
        }

        if (! Schema::hasTable('extrato')) {
            Schema::create('extrato', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('id_pedido');
                $table->string('descricao', 255)->nullable();
                $table->timestamp('criado_em')->nullable()->useCurrent();

                $table->foreign('id_pedido', 'fk_pedido_extrato')
                    ->references('id')
                    ->on('pedido');
            });
        }

        if (! Schema::hasTable('produto_pedido')) {
            Schema::create('produto_pedido', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('id_pedido');
                $table->unsignedInteger('id_produto');
                $table->integer('quantidade');
                $table->decimal('preco_unitario', 10, 2);
                $table->string('observacao', 150)->nullable();

                $table->foreign('id_pedido', 'fk_pedido_produto_pedido')
                    ->references('id')
                    ->on('pedido');
                $table->foreign('id_produto', 'fk_produto_produto_pedido')
                    ->references('id')
                    ->on('produto');
            });
        }

        if (! Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table): void {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('payload');
                $table->integer('last_activity')->index();
            });
        }
    }

    /**
     * This migration is a non-destructive baseline for a pre-existing
     * production database. Dropping its tables during rollback is unsafe.
     */
    public function down(): void
    {
        // Intentionally left blank.
    }
};
