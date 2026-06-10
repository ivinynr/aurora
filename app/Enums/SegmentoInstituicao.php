<?php

namespace App\Enums;

enum SegmentoInstituicao: string
{
    case ANIMAIS = 'animais';
    case EMERGENCIA = 'emergencia';
    case FOME = 'fome';
    case EDUCACAO = 'educacao';
    case SAUDE = 'saude';
    case MEIO_AMBIENTE = 'meio_ambiente';
    case CULTURA = 'cultura';
    case MORADIA = 'moradia';

    public function label(): string
    {
        return match ($this) {
            self::ANIMAIS => 'Animais',
            self::EMERGENCIA => 'Emergência',
            self::FOME => 'Fome',
            self::EDUCACAO => 'Educação',
            self::SAUDE => 'Saúde',
            self::MEIO_AMBIENTE => 'Meio Ambiente',
            self::CULTURA => 'Cultura',
            self::MORADIA => 'Moradia',
        };
    }

    public function cor(): string
    {
        return match ($this) {
            self::ANIMAIS => 'sage',
            self::EMERGENCIA => 'rose',
            self::FOME => 'honey',
            self::EDUCACAO => 'terra',
            self::SAUDE => 'emerald',
            self::MEIO_AMBIENTE => 'sage',
            self::CULTURA => 'amber',
            self::MORADIA => 'slate',
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
            self::cases(),
        );
    }
}
