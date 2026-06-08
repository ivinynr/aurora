<?php

namespace App\Models;

use App\Enums\SituacaoDoacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doacao extends Model
{
    use HasFactory;

    protected $table = 'donations';

    protected $fillable = [
        'campanha_id',
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

    public function campanha(): BelongsTo
    {
        return $this->belongsTo(Campanha::class, 'campanha_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transacoes(): HasMany
    {
        return $this->hasMany(TransacaoPagamento::class, 'doacao_id');
    }

    public function nomeExibicao(): string
    {
        return $this->anonimo ? 'Apoiador Anônimo' : $this->nome_doador;
    }
}
