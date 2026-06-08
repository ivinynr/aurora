<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function campanha(): BelongsTo
    {
        return $this->belongsTo(Campanha::class, 'campanha_id');
    }
}
