<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AtualizacaoInstituicao extends Model
{
    use HasFactory;

    protected $table = 'institution_updates';

    protected $fillable = [
        'instituicao_id',
        'titulo',
        'descricao',
        'imagem',
    ];

    protected $appends = [
        'imagem_url',
    ];

    public function instituicao(): BelongsTo
    {
        return $this->belongsTo(Instituicao::class, 'instituicao_id');
    }

    public function getImagemUrlAttribute(): ?string
    {
        if (!$this->imagem) {
            return null;
        }

        return Str::startsWith($this->imagem, ['http://', 'https://'])
            ? $this->imagem
            : Storage::url($this->imagem);
    }
}
