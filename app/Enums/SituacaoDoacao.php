<?php

namespace App\Enums;

enum SituacaoDoacao: string
{
    case PENDENTE = 'pendente';
    case CONFIRMADA = 'confirmada';
    case EXPIRADA = 'expirada';
    case CANCELADA = 'cancelada';

    public function label(): string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::CONFIRMADA => 'Confirmada',
            self::EXPIRADA => 'Expirada',
            self::CANCELADA => 'Cancelada',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function opcoes(): array
    {
        return array_map(
            fn (self $caso) => ['valor' => $caso->value, 'label' => $caso->label()],
            self::cases()
        );
    }
}
