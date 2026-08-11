<?php

namespace App\Exceptions;

use Exception;

class ProdutoComPedidosVinculadosException extends Exception
{
    public function __construct(string $message = 'Não é possível excluir um produto com pedidos vinculados.')
       {
           parent::__construct($message);
       }
}
