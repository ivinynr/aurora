<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instituicao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'institutions';

    protected $fillable = [
        'user_id',
        'nome',
        'slug',
        'descricao',
        'missao',
        'meta',
        'valor_arrecadado',
        'imagem',
        'video_url',
        'telefone',
        'email',
        'instagram',
        'website',
        'chave_pix',
        'endereco',
        'cidade',
        'estado',
        'ativa',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'decimal:2',
            'valor_arrecadado' => 'decimal:2',
            'ativa' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doacoes(): HasMany
    {
        return $this->hasMany(Doacao::class, 'instituicao_id');
    }

    public function atualizacoes(): HasMany
    {
        return $this->hasMany(AtualizacaoInstituicao::class, 'instituicao_id');
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
}
