<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'data_hora', 'profissional', 'anotacoes'];

    protected $casts = ['data_hora' => 'datetime'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
