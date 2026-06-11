<?php

namespace App\Services;

use App\Enums\SituacaoCampanha;
use App\Models\AtualizacaoCampanha;
use App\Models\Campanha;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CampanhaService
{
    public function destaques(int $limite = 3): Collection
    {
        return Campanha::with('instituicao')
            ->withCount(['doacoes as doacoes_confirmadas_count' => fn ($q) => $q->where('situacao', 'confirmada')])
            ->ativas()
            ->emDestaque()
            ->orderByDesc('valor_arrecadado')
            ->limit($limite)
            ->get();
    }

    public function listarPaginado(array $filtros = []): LengthAwarePaginator
    {
        $query = Campanha::with('instituicao')->ativas();

        if (! empty($filtros['busca'])) {
            $busca = $filtros['busca'];
            $query->where(function ($q) use ($busca) {
                $q->where('titulo', 'like', "%{$busca}%")
                    ->orWhere('resumo', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            });
        }

        return $query->orderByDesc('destaque')
            ->orderByDesc('valor_arrecadado')
            ->paginate(12)
            ->withQueryString();
    }

    public function buscarPorSlug(string $slug): ?Campanha
    {
        return Campanha::with([
            'instituicao',
            'atualizacoes' => fn ($q) => $q->orderByDesc('created_at'),
            'doacoes' => fn ($q) => $q->where('situacao', 'confirmada')
                ->orderByDesc('created_at')
                ->limit(50),
        ])->where('slug', $slug)->first();
    }

    public function listarTodas(): Collection
    {
        return Campanha::with('instituicao')
            ->withCount(['doacoes as total_doadores' => fn ($q) => $q->where('situacao', 'confirmada')])
            ->orderByDesc('created_at')
            ->get();
    }

    public function criar(array $dados): Campanha
    {
        $dados['slug'] = $this->gerarSlugUnico($dados['titulo']);
        $dados['valor_arrecadado'] = 0;

        return Campanha::create($dados);
    }

    public function atualizar(Campanha $campanha, array $dados): Campanha
    {
        if (isset($dados['titulo']) && $dados['titulo'] !== $campanha->titulo) {
            $dados['slug'] = $this->gerarSlugUnico($dados['titulo'], $campanha->id);
        }

        $campanha->update($dados);

        return $campanha->fresh();
    }

    public function encerrar(Campanha $campanha): Campanha
    {
        $campanha->update(['situacao' => SituacaoCampanha::ENCERRADA->value]);

        return $campanha->fresh();
    }

    public function publicarAtualizacao(Campanha $campanha, array $dados): AtualizacaoCampanha
    {
        return $campanha->atualizacoes()->create($dados);
    }

    public function removerAtualizacao(AtualizacaoCampanha $atualizacao): void
    {
        $atualizacao->delete();
    }

    private function gerarSlugUnico(string $titulo, ?int $ignorarId = null): string
    {
        $base = Str::slug($titulo);
        $slug = $base;
        $contador = 2;

        while (
            Campanha::where('slug', $slug)
                ->when($ignorarId, fn ($q) => $q->where('id', '!=', $ignorarId))
                ->exists()
        ) {
            $slug = "{$base}-{$contador}";
            $contador++;
        }

        return $slug;
    }
}
