<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransacaoPagamento extends Model
{
    use HasFactory;

    protected $table = 'payment_transactions';

    protected $fillable = [
        'doacao_id',
        'gateway',
        'transaction_id',
        'valor',
        'status',
        'qr_code',
        'qr_code_text',
        'expira_em',
        'pago_em',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'expira_em' => 'datetime',
            'pago_em' => 'datetime',
            'payload' => 'array',
        ];
    }

    public function doacao(): BelongsTo
    {
        return $this->belongsTo(Doacao::class, 'doacao_id');
    }
}
