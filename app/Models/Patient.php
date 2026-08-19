<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    // whitelist explicita: evita mass assignment de colunas nao previstas
    protected $fillable = [
        'name', 'birth_date', 'marital_status', 'telephone', 'rg', 'cpf', 'email',
        'address', 'Complement', 'house_number', 'city', 'district',
        'time_service', 'consultation', 'name_father', 'address_father', 'city_father',
    ];

    public function atendimentos()
    {
        return $this->hasMany(Atendimento::class)->orderBy('data_hora', 'desc');
    }
}
