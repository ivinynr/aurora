<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'logo',
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
            'ativa' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campanhas(): HasMany
    {
        return $this->hasMany(Campanha::class, 'instituicao_id');
    }

    public function doacoes(): HasManyThrough
    {
        return $this->hasManyThrough(
            Doacao::class,
            Campanha::class,
            'instituicao_id',
            'campanha_id',
        );
    }

    public function totalArrecadado(): float
    {
        return (float) $this->campanhas()->sum('valor_arrecadado');
    }

    public function totalDoadores(): int
    {
        return $this->doacoes()
            ->where('donations.situacao', 'confirmada')
            ->distinct('donations.nome_doador')
            ->count('donations.nome_doador');
    }

    public function logoUrl(): ?string
    {
        if (! $this->logo) {
            return null;
        }

        return Str::startsWith($this->logo, ['http://', 'https://'])
            ? $this->logo
            : Storage::url($this->logo);
    }
}
