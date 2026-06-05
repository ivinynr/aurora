<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function instituicao(): BelongsTo
    {
        return $this->belongsTo(Instituicao::class, 'instituicao_id');
    }
}
