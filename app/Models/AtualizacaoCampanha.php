<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AtualizacaoCampanha extends Model
{
    use HasFactory;

    protected $table = 'campaign_updates';

    protected $fillable = [
        'campanha_id',
        'titulo',
        'descricao',
        'imagem',
    ];

    protected $appends = [
        'imagem_url',
    ];

    public function campanha(): BelongsTo
    {
        return $this->belongsTo(Campanha::class, 'campanha_id');
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
