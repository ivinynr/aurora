<?php

namespace App\Models;

use App\Enums\SituacaoCampanha;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Campanha extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'campaigns';

    protected $fillable = [
        'instituicao_id',
        'titulo',
        'slug',
        'resumo',
        'descricao',
        'imagem',
        'video_url',
        'meta',
        'valor_arrecadado',
        'situacao',
        'destaque',
        'data_inicio',
        'data_fim',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'decimal:2',
            'valor_arrecadado' => 'decimal:2',
            'situacao' => SituacaoCampanha::class,
            'destaque' => 'boolean',
            'data_inicio' => 'date',
            'data_fim' => 'date',
        ];
    }

    public function instituicao(): BelongsTo
    {
        return $this->belongsTo(Instituicao::class, 'instituicao_id');
    }

    public function doacoes(): HasMany
    {
        return $this->hasMany(Doacao::class, 'campanha_id');
    }

    public function atualizacoes(): HasMany
    {
        return $this->hasMany(AtualizacaoCampanha::class, 'campanha_id');
    }

    public function scopeAtivas(Builder $query): Builder
    {
        return $query->where('situacao', SituacaoCampanha::ATIVA->value);
    }

    public function scopeEmDestaque(Builder $query): Builder
    {
        return $query->where('destaque', true);
    }

    public function percentualArrecadado(): float
    {
        if ($this->meta <= 0) {
            return 0;
        }

        return min(100, round(($this->valor_arrecadado / $this->meta) * 100, 1));
    }

    public function totalDoadores(): int
    {
        return $this->doacoes()
            ->where('situacao', 'confirmada')
            ->distinct('nome_doador')
            ->count('nome_doador');
    }

    public function estaEncerrada(): bool
    {
        return $this->situacao === SituacaoCampanha::ENCERRADA;
    }

    public function aceitaDoacoes(): bool
    {
        return $this->situacao === SituacaoCampanha::ATIVA;
    }

    public function imagemUrl(): ?string
    {
        if (! $this->imagem) {
            return null;
        }

        return Str::startsWith($this->imagem, ['http://', 'https://'])
            ? $this->imagem
            : Storage::url($this->imagem);
    }
}
