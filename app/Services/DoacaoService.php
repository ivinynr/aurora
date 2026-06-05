<?php

namespace App\Services;

use App\Enums\SituacaoDoacao;
use App\Models\Doacao;
use App\Models\Instituicao;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DoacaoService
{
    public function registrar(Instituicao $instituicao, array $dados): Doacao
    {
        return Doacao::create([
            'instituicao_id' => $instituicao->id,
            'nome_doador' => $dados['nome_doador'],
            'email_doador' => $dados['email_doador'] ?? null,
            'valor' => $dados['valor'],
            'situacao' => SituacaoDoacao::PENDENTE->value,
            'anonimo' => $dados['anonimo'] ?? false,
            'mensagem' => $dados['mensagem'] ?? null,
        ]);
    }

    public function confirmar(Doacao $doacao, string $transactionId): Doacao
    {
        DB::transaction(function () use ($doacao, $transactionId) {
            $doacao->update([
                'situacao' => SituacaoDoacao::CONFIRMADA->value,
                'transaction_id' => $transactionId,
            ]);

            $doacao->instituicao->increment('valor_arrecadado', $doacao->valor);
        });

        return $doacao->fresh();
    }

    public function ultimasDoacoes(int $limite = 10): Collection
    {
        return Doacao::with('instituicao')
            ->where('situacao', SituacaoDoacao::CONFIRMADA->value)
            ->orderBy('created_at', 'desc')
            ->limit($limite)
            ->get();
    }

    public function listarPaginado(array $filtros = []): LengthAwarePaginator
    {
        $query = Doacao::with('instituicao');

        if (!empty($filtros['instituicao_id'])) {
            $query->where('instituicao_id', $filtros['instituicao_id']);
        }

        if (!empty($filtros['situacao'])) {
            $query->where('situacao', $filtros['situacao']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(20);
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
