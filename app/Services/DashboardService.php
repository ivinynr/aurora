<?php

namespace App\Services;

use App\Enums\SituacaoCampanha;
use App\Enums\SituacaoDoacao;
use App\Models\Campanha;
use App\Models\Doacao;
use App\Models\Instituicao;
use Illuminate\Support\Collection;

class DashboardService
{
    public function __construct(
        private DoacaoService $doacaoService,
    ) {}

    public function resumo(): array
    {
        return [
            ...$this->doacaoService->estatisticas(),
            'total_campanhas' => Campanha::count(),
            'campanhas_ativas' => Campanha::where('situacao', SituacaoCampanha::ATIVA->value)->count(),
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

    public function campanhasMaisArrecadadas(int $limite = 5): Collection
    {
        return Campanha::with('instituicao')
            ->where('valor_arrecadado', '>', 0)
            ->orderByDesc('valor_arrecadado')
            ->limit($limite)
            ->get();
    }

    public function doacoesRecentes(int $limite = 10): Collection
    {
        return $this->doacaoService->ultimasDoacoes($limite);
    }
}
