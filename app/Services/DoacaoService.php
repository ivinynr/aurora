<?php

namespace App\Services;

use App\Enums\SituacaoDoacao;
use App\Models\Campanha;
use App\Models\Doacao;
use App\Models\TransacaoPagamento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DoacaoService
{
    public function registrar(Campanha $campanha, array $dados): Doacao
    {
        return Doacao::create([
            'campanha_id' => $campanha->id,
            'user_id' => $dados['user_id'] ?? null,
            'nome_doador' => $dados['nome_doador'],
            'email_doador' => $dados['email_doador'] ?? null,
            'valor' => $dados['valor'],
            'situacao' => SituacaoDoacao::PENDENTE->value,
            'anonimo' => $dados['anonimo'] ?? false,
            'mensagem' => $dados['mensagem'] ?? null,
        ]);
    }

    public function registrarCobranca(Doacao $doacao, array $pagamento): TransacaoPagamento
    {
        $transacao = TransacaoPagamento::create([
            'doacao_id' => $doacao->id,
            'gateway' => $pagamento['gateway'] ?? 'confrapix',
            'transaction_id' => $pagamento['transaction_id'] ?? null,
            'valor' => $doacao->valor,
            'situacao' => SituacaoDoacao::PENDENTE->value,
            'qr_code' => $pagamento['qr_code'] ?? null,
            'qr_code_text' => $pagamento['qr_code_text'] ?? null,
            'expira_em' => $pagamento['expiracao'] ?? null,
            'payload' => $pagamento,
        ]);

        if (! empty($pagamento['transaction_id'])) {
            $doacao->update(['transaction_id' => $pagamento['transaction_id']]);
        }

        return $transacao;
    }

    public function confirmar(Doacao $doacao, string $transactionId): Doacao
    {
        DB::transaction(function () use ($doacao, $transactionId) {
            $doacao->update([
                'situacao' => SituacaoDoacao::CONFIRMADA->value,
                'transaction_id' => $transactionId,
            ]);

            $doacao->campanha()->increment('valor_arrecadado', $doacao->valor);

            $doacao->transacoes()->latest('id')->limit(1)->update([
                'situacao' => SituacaoDoacao::CONFIRMADA->value,
                'transaction_id' => $transactionId,
                'pago_em' => now(),
            ]);
        });

        return $doacao->fresh();
    }

    public function cancelar(Doacao $doacao): Doacao
    {
        DB::transaction(function () use ($doacao) {
            $eraConfirmada = $doacao->situacao === SituacaoDoacao::CONFIRMADA;

            $doacao->update(['situacao' => SituacaoDoacao::CANCELADA->value]);

            if ($eraConfirmada) {
                $doacao->campanha()->decrement('valor_arrecadado', $doacao->valor);
            }

            $doacao->transacoes()->latest('id')->limit(1)->update([
                'situacao' => SituacaoDoacao::CANCELADA->value,
            ]);
        });

        return $doacao->fresh();
    }

    /**
     * Aplica o status recebido no webhook da ConfraPix à doação correspondente.
     * Retorna a doação atualizada, ou null quando o payload não casa com nenhuma doação.
     */
    public function sincronizarPorCallback(array $payload): ?Doacao
    {
        $transactionId = (string) ($payload['id'] ?? '');

        if ($transactionId === '') {
            return null;
        }

        $doacao = Doacao::where('transaction_id', $transactionId)->first();

        if (! $doacao) {
            return null;
        }

        $status = $payload['status'] ?? '';
        $pago = $status === 'succeeded' || ! empty($payload['confirmed']);

        if ($pago && $doacao->situacao === SituacaoDoacao::PENDENTE) {
            return $this->confirmar($doacao, $transactionId);
        }

        if ($status === 'canceled' && $doacao->situacao !== SituacaoDoacao::CANCELADA) {
            return $this->cancelar($doacao);
        }

        return $doacao;
    }

    public function ultimasDoacoes(int $limite = 10): Collection
    {
        return Doacao::with('campanha.instituicao')
            ->where('situacao', SituacaoDoacao::CONFIRMADA->value)
            ->orderByDesc('created_at')
            ->limit($limite)
            ->get();
    }

    public function listarPaginado(array $filtros = []): LengthAwarePaginator
    {
        $query = Doacao::with('campanha.instituicao');

        if (! empty($filtros['campanha_id'])) {
            $query->where('campanha_id', $filtros['campanha_id']);
        }

        if (! empty($filtros['situacao'])) {
            $query->where('situacao', $filtros['situacao']);
        }

        return $query->orderByDesc('created_at')->paginate(20)->withQueryString();
    }

    public function estatisticas(): array
    {
        $confirmadas = Doacao::where('situacao', SituacaoDoacao::CONFIRMADA->value);

        return [
            'total_doado' => (float) $confirmadas->sum('valor'),
            'total_doacoes' => $confirmadas->count(),
            'ticket_medio' => (float) $confirmadas->avg('valor') ?: 0,
            'total_doadores' => $confirmadas->distinct('nome_doador')->count('nome_doador'),
        ];
    }
}
