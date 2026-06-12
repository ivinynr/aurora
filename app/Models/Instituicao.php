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
use App\Enums\SegmentoInstituicao;

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
        'imagem',
        'telefone',
        'email',
        'instagram',
        'website',
        'chave_pix',
        'endereco',
        'cidade',
        'estado',
        'ativa',
        'segmento',
        'fotos',
        'selos',
    ];

    protected $appends = [
        'logo_url',
        'fotos_urls',
        'segmento_label',
        'segmento_cor',
    ];

    protected function casts(): array
    {
        return [
            'ativa' => 'boolean',
            'segmento' => SegmentoInstituicao::class,
            'fotos' => 'array',
            'selos' => 'array',
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

    public function atualizacoes(): HasMany
    {
        return $this->hasMany(AtualizacaoInstituicao::class, 'instituicao_id');
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
        if (! $this->imagem) {
            return null;
        }

        return Str::startsWith($this->imagem, ['http://', 'https://'])
            ? $this->imagem
            : Storage::url($this->imagem);
    }

    public function fotosUrls(): array
    {
        if (! $this->fotos) {
            return [];
        }

        return array_map(
            fn (string $foto) => Str::startsWith($foto, ['http://', 'https://'])
                ? $foto
                : Storage::url($foto),
            $this->fotos,
        );
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logoUrl();
    }

    public function getFotosUrlsAttribute(): array
    {
        return $this->fotosUrls();
    }

    public function getSegmentoLabelAttribute(): ?string
    {
        return $this->segmento?->label();
    }

    public function getSegmentoCorAttribute(): ?string
    {
        return $this->segmento?->cor();
    }
}
