<?php

namespace App\Services\Pagamento;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $resposta = Http::withToken($this->token)
                ->timeout(15)
                ->post("{$this->baseUrl}/api/v1/cobrancas/pix", [
                    'valor' => $valor,
                    'descricao' => $descricao,
                    'identificador' => $identificador,
                ]);

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

            $dados = $resposta->json();

            return [
                'transaction_id' => $dados['transaction_id'],
                'qr_code' => $dados['qr_code'],
                'qr_code_text' => $dados['qr_code_text'],
                'valor' => $dados['valor'],
                'expiracao' => $dados['expiracao'],
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
            $resposta = Http::withToken($this->token)
                ->timeout(15)
                ->get("{$this->baseUrl}/api/v1/cobrancas/{$transactionId}");

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

            $dados = $resposta->json();

            return [
                'situacao' => $dados['situacao'],
                'transaction_id' => $dados['transaction_id'],
                'pago_em' => $dados['pago_em'] ?? null,
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
}
