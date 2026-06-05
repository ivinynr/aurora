<?php

namespace App\Services\Pagamento;

use Illuminate\Support\Str;

class MockPagamentoService implements PagamentoServiceInterface
{
    public function gerarCobrancaPix(float $valor, string $descricao, string $identificador): array
    {
        $transactionId = 'MOCK_' . Str::uuid()->toString();

        $qrCodeTexto = "00020126580014br.gov.bcb.pix0136{$transactionId}5204000053039865802BR5913CONFRADOA6008BRASILIA62070503***6304MOCK";

        return [
            'transaction_id' => $transactionId,
            'qr_code' => base64_encode("MOCK_QR_CODE_{$transactionId}"),
            'qr_code_text' => $qrCodeTexto,
            'valor' => $valor,
            'expiracao' => now()->addMinutes(30)->toIso8601String(),
        ];
    }

    public function consultarPagamento(string $transactionId): array
    {
        return [
            'situacao' => 'confirmada',
            'transaction_id' => $transactionId,
            'pago_em' => now()->toIso8601String(),
        ];
    }
}
