<?php

namespace App\Services;

use App\Enums\SituacaoDoacao;
use App\Models\Doacao;
use App\Models\Instituicao;
use Illuminate\Support\Collection;

class DashboardService
{
    public function __construct(
        private DoacaoService $doacaoService,
        private InstituicaoService $instituicaoService,
    ) {}

    public function resumo(): array
    {
        $estatisticasDoacoes = $this->doacaoService->estatisticas();

        return [
            ...$estatisticasDoacoes,
            'total_instituicoes' => Instituicao::where('ativa', true)->count(),
        ];
    }

    public function doacoesPorDia(int $dias = 30): Collection
    {
        return Doacao::where('situacao', SituacaoDoacao::CONFIRMADA->value)
            ->where('created_at', '>=', now()->subDays($dias))
            ->selectRaw('DATE(created_at) as data, SUM(valor) as total, COUNT(*) as quantidade')
            ->groupBy('data')
            ->orderBy('data')
            ->get();
    }

    public function instituicoesMaisArrecadadas(int $limite = 5): Collection
    {
        return Instituicao::where('ativa', true)
            ->where('valor_arrecadado', '>', 0)
            ->orderBy('valor_arrecadado', 'desc')
            ->limit($limite)
            ->get();
    }

    public function doacoesRecentes(int $limite = 10): Collection
    {
        return $this->doacaoService->ultimasDoacoes($limite);
    }
}
