<?php

namespace App\Services\Pagamento;

use App\Enums\SituacaoDoacao;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class ConfraPixService implements PagamentoServiceInterface
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.confrapix.url'), '/');
        $this->token = config('services.confrapix.token');
    }

    public function gerarCobrancaPix(float $valor, string $descricao, string $identificador): array
    {
        try {
            $resposta = $this->cliente()
                ->post("{$this->baseUrl}/transaction-ec/store", array_filter([
                    'amount' => $valor,
                    'description' => $descricao,
                    'callback_url' => $this->callbackUrl(),
                ]));

            if ($resposta->failed()) {
                Log::error('ConfraPix: falha ao gerar cobrança PIX', [
                    'status' => $resposta->status(),
                    'body' => $resposta->body(),
                    'identificador' => $identificador,
                ]);

                return [
                    'erro' => true,
                    'mensagem' => 'Não foi possível gerar a cobrança PIX porque o serviço de pagamento retornou um erro.',
                ];
            }

            $transacao = $this->extrairTransacao($resposta->json());
            $pix = $transacao['pix'] ?? [];

            return [
                'transaction_id' => (string) ($transacao['id'] ?? ''),
                'uuid' => $transacao['uuid'] ?? null,
                'gateway' => 'confrapix',
                'qr_code' => $pix['url'] ?? null,
                'qr_code_text' => $pix['code'] ?? null,
                'valor' => $transacao['amount'] ?? $valor,
                'expiracao' => $transacao['expired_in'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('ConfraPix: exceção ao gerar cobrança PIX', [
                'mensagem' => $e->getMessage(),
                'identificador' => $identificador,
            ]);

            return [
                'erro' => true,
                'mensagem' => 'Não foi possível gerar a cobrança PIX porque o serviço de pagamento está indisponível.',
            ];
        }
    }

    public function consultarPagamento(string $transactionId): array
    {
        try {
            $resposta = $this->cliente()
                ->get("{$this->baseUrl}/transaction-ec/show/{$transactionId}");

            if ($resposta->failed()) {
                Log::error('ConfraPix: falha ao consultar pagamento', [
                    'status' => $resposta->status(),
                    'body' => $resposta->body(),
                    'transaction_id' => $transactionId,
                ]);

                return [
                    'erro' => true,
                    'mensagem' => 'Não foi possível consultar o pagamento porque o serviço retornou um erro.',
                ];
            }

            $transacao = $this->extrairTransacao($resposta->json());
            $status = $transacao['status'] ?? '';

            return [
                'pago' => $status === 'succeeded' || ! empty($transacao['confirmed']),
                'situacao' => $this->mapearSituacao($status),
                'transaction_id' => (string) ($transacao['id'] ?? $transactionId),
                'pago_em' => $transacao['payed_in'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('ConfraPix: exceção ao consultar pagamento', [
                'mensagem' => $e->getMessage(),
                'transaction_id' => $transactionId,
            ]);

            return [
                'erro' => true,
                'mensagem' => 'Não foi possível consultar o pagamento porque o serviço está indisponível.',
            ];
        }
    }

    public function cancelarPagamento(string $transactionId): array
    {
        try {
            $resposta = $this->cliente()
                ->put("{$this->baseUrl}/transaction-ec/cancel/{$transactionId}");

            if ($resposta->failed()) {
                Log::error('ConfraPix: falha ao cancelar transação', [
                    'status' => $resposta->status(),
                    'body' => $resposta->body(),
                    'transaction_id' => $transactionId,
                ]);

                return [
                    'erro' => true,
                    'mensagem' => 'Não foi possível cancelar a transação porque o serviço retornou um erro.',
                ];
            }

            return [
                'cancelado' => true,
                'transaction_id' => $transactionId,
            ];
        } catch (\Exception $e) {
            Log::error('ConfraPix: exceção ao cancelar transação', [
                'mensagem' => $e->getMessage(),
                'transaction_id' => $transactionId,
            ]);

            return [
                'erro' => true,
                'mensagem' => 'Não foi possível cancelar a transação porque o serviço está indisponível.',
            ];
        }
    }

    private function cliente(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withToken($this->token)->acceptJson()->timeout(15);
    }

    /**
     * A API encapsula a transação em "transaction"; toleramos também "data" ou a raiz.
     */
    private function extrairTransacao(?array $resposta): array
    {
        if (empty($resposta)) {
            return [];
        }

        return $resposta['transaction'] ?? $resposta['data'] ?? $resposta;
    }

    private function mapearSituacao(string $status): string
    {
        return match ($status) {
            'succeeded' => SituacaoDoacao::CONFIRMADA->value,
            'canceled' => SituacaoDoacao::CANCELADA->value,
            default => SituacaoDoacao::PENDENTE->value,
        };
    }

    /**
     * URL de webhook registrada na criação da transação. Só é enviada quando a aplicação
     * está publicamente acessível (em localhost a API não conseguiria nos chamar de volta).
     */
    private function callbackUrl(): ?string
    {
        if (! Route::has('webhooks.confrapix')) {
            return null;
        }

        $host = parse_url((string) config('app.url'), PHP_URL_HOST);

        if (in_array($host, ['localhost', '127.0.0.1', null], true)) {
            return null;
        }

        $url = route('webhooks.confrapix');
        $secret = config('services.confrapix.webhook_secret');

        return $secret ? $url.'?token='.urlencode($secret) : $url;
    }
}
