<?php

namespace App\Enums;

enum SituacaoCampanha: string
{
    case RASCUNHO = 'rascunho';
    case ATIVA = 'ativa';
    case ENCERRADA = 'encerrada';

    public function label(): string
    {
        return match ($this) {
            self::RASCUNHO => 'Rascunho',
            self::ATIVA => 'Ativa',
            self::ENCERRADA => 'Encerrada',
        };
    }

    public function cor(): string
    {
        return match ($this) {
            self::RASCUNHO => 'bark',
            self::ATIVA => 'sage',
            self::ENCERRADA => 'terra',
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
