<?php

namespace App\Services\Pagamento;

interface PagamentoServiceInterface
{
    public function gerarCobrancaPix(float $valor, string $descricao, string $identificador): array;

    public function consultarPagamento(string $transactionId): array;
}
