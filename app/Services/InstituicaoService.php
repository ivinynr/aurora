<?php

namespace App\Services;

use App\Models\Instituicao;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

class InstituicaoService
{
    public function listarAtivas(): Collection
    {
        return Instituicao::where('ativa', true)
            ->withCount('campanhas')
            ->orderBy('nome')
            ->get();
    }

    public function listarPaginado(array $filtros = []): LengthAwarePaginator
    {
        $query = Instituicao::where('ativa', true);

        if (! empty($filtros['busca'])) {
            $query->where(function ($q) use ($filtros) {
                $q->where('nome', 'like', "%{$filtros['busca']}%")
                    ->orWhere('descricao', 'like', "%{$filtros['busca']}%")
                    ->orWhere('cidade', 'like', "%{$filtros['busca']}%");
            });
        }

        if (! empty($filtros['cidade'])) {
            $query->where('cidade', $filtros['cidade']);
        }

        return $query->withCount('campanhas')
            ->orderBy('nome')
            ->paginate(12)
            ->withQueryString();
    }

    public function buscarPorSlug(string $slug): ?Instituicao
    {
        return Instituicao::with([
            'campanhas' => fn ($q) => $q->ativas()->orderByDesc('valor_arrecadado'),
        ])->where('slug', $slug)->where('ativa', true)->first();
    }

    public function listarTodas(): Collection
    {
        return Instituicao::withCount('campanhas')->orderBy('nome')->get();
    }

    public function criar(array $dados): Instituicao
    {
        $dados['slug'] = Str::slug($dados['nome']);

        return Instituicao::create($dados);
    }

    public function atualizar(Instituicao $instituicao, array $dados): Instituicao
    {
        if (isset($dados['nome'])) {
            $dados['slug'] = Str::slug($dados['nome']);
        }

        $instituicao->update($dados);

        return $instituicao->fresh();
    }

    public function cidadesDisponiveis(): SupportCollection
    {
        return Instituicao::where('ativa', true)
            ->whereNotNull('cidade')
            ->distinct()
            ->orderBy('cidade')
            ->pluck('cidade');
    }

    public function destaquesPagina(int $limite = 6): Collection
    {
        return Instituicao::where('ativa', true)
            ->withCount('campanhas')
            ->orderByDesc('campanhas_count')
            ->limit($limite)
            ->get();
    }

    public function listarPorSegmento(string $segmento, int $excluirId, int $limite = 4): Collection
    {
        return Instituicao::where('ativa', true)
            ->where('segmento', $segmento)
            ->where('id', '!=', $excluirId)
            ->withCount('campanhas')
            ->limit($limite)
            ->get();
    }
}
