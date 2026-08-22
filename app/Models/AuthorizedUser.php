<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizedUser extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'role', 'invited_by', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    // rotulos amigaveis dos papeis
    public const PAPEIS = [
        'dono'       => 'Dono',
        'tutor'      => 'Tutor',
        'estagiario' => 'Estagiário',
    ];

    public function rotuloPapel(): string
    {
        return self::PAPEIS[$this->role] ?? $this->role;
    }
}
