<?php

namespace App\Models;

use App\Enums\TipoUsuario;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
        'telefone',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tipo' => TipoUsuario::class,
        ];
    }

    public function ehAdmin(): bool
    {
        return $this->tipo === TipoUsuario::ADMINISTRADOR;
    }

    public function doacoes(): HasMany
    {
        return $this->hasMany(Doacao::class);
    }

    public function instituicoes(): HasMany
    {
        return $this->hasMany(Instituicao::class);
    }
}
