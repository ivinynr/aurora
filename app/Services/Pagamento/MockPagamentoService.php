<?php

namespace App\Services\Pagamento;

use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MockPagamentoService implements PagamentoServiceInterface
{
    public function gerarCobrancaPix(float $valor, string $descricao, string $identificador): array
    {
        $transactionId = 'MOCK_'.Str::uuid()->toString();

        $qrCodeTexto = "00020126580014br.gov.bcb.pix0136{$transactionId}5204000053039865802BR5913CONFRADOA6008BRASILIA62070503***6304MOCK";

        $svg = QrCode::format('svg')->size(220)->margin(1)->generate($qrCodeTexto);

        return [
            'transaction_id' => $transactionId,
            'gateway' => 'mock',
            'qr_code' => 'data:image/svg+xml;base64,'.base64_encode($svg),
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
