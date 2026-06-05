<?php

namespace App\Models;

use App\Enums\SituacaoDoacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doacao extends Model
{
    use HasFactory;

    protected $table = 'donations';

    protected $fillable = [
        'instituicao_id',
        'user_id',
        'nome_doador',
        'email_doador',
        'valor',
        'transaction_id',
        'situacao',
        'anonimo',
        'mensagem',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'situacao' => SituacaoDoacao::class,
            'anonimo' => 'boolean',
        ];
    }

    public function instituicao(): BelongsTo
    {
        return $this->belongsTo(Instituicao::class, 'instituicao_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nomeExibicao(): string
    {
        return $this->anonimo ? 'Apoiador Anônimo' : $this->nome_doador;
    }
}
