<?php

namespace App\Enums;

enum TipoUsuario: string
{
    case ADMINISTRADOR = 'administrador';
    case DOADOR = 'doador';

    public function label(): string
    {
        return match ($this) {
            self::ADMINISTRADOR => 'Administrador',
            self::DOADOR => 'Doador',
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
