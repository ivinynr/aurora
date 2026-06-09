<?php

namespace App\Services\Pagamento;

use Illuminate\Support\Str;

class MockPagamentoService implements PagamentoServiceInterface
{
    public function gerarCobrancaPix(float $valor, string $descricao, string $identificador): array
    {
        $transactionId = 'MOCK_'.Str::uuid()->toString();

        return [
            'transaction_id' => $transactionId,
            'gateway' => 'mock',
            'qr_code' => '/images/pix-qrcode.jpeg',
            'qr_code_text' => null,
            'valor' => $valor,
            'expiracao' => now()->addMinutes(30)->toIso8601String(),
        ];
    }

    public function consultarPagamento(string $transactionId): array
    {
        return [
            'pago' => true,
            'situacao' => 'confirmada',
            'transaction_id' => $transactionId,
            'pago_em' => now()->toIso8601String(),
        ];
    }

    public function cancelarPagamento(string $transactionId): array
    {
        return [
            'cancelado' => true,
            'transaction_id' => $transactionId,
        ];
    }
}
