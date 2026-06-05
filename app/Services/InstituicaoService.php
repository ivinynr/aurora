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
            ->withCount(['doacoes as total_doadores' => function ($q) {
                $q->where('situacao', 'confirmada');
            }])
            ->orderBy('valor_arrecadado', 'desc')
            ->get();
    }

    public function listarPaginado(array $filtros = []): LengthAwarePaginator
    {
        $query = Instituicao::where('ativa', true);

        if (!empty($filtros['busca'])) {
            $query->where(function ($q) use ($filtros) {
                $q->where('nome', 'like', "%{$filtros['busca']}%")
                    ->orWhere('descricao', 'like', "%{$filtros['busca']}%")
                    ->orWhere('cidade', 'like', "%{$filtros['busca']}%");
            });
        }

        if (!empty($filtros['cidade'])) {
            $query->where('cidade', $filtros['cidade']);
        }

        return $query->withCount(['doacoes as total_doadores' => function ($q) {
            $q->where('situacao', 'confirmada');
        }])->orderBy('valor_arrecadado', 'desc')->paginate(12);
    }

    public function buscarPorSlug(string $slug): ?Instituicao
    {
        return Instituicao::with(['doacoes' => function ($q) {
            $q->where('situacao', 'confirmada')->orderBy('created_at', 'desc')->limit(50);
        }, 'atualizacoes' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->where('slug', $slug)->where('ativa', true)->first();
    }

    public function listarTodas(): Collection
    {
        return Instituicao::withCount(['doacoes as total_doadores' => function ($q) {
            $q->where('situacao', 'confirmada');
        }])->orderBy('nome')->get();
    }

    public function criar(array $dados): Instituicao
    {
        $dados['slug'] = Str::slug($dados['nome']);
        $dados['valor_arrecadado'] = 0;

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
}
