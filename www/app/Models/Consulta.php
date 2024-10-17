<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = ['paciente_id', 'user_id', 'animal_id', 'data', 'horario_inicio', 'horario_fim', 'informacao'];

    public function animal()
    {
        return $this->belongsTo(Animal::class); // Ajuste se o relacionamento for diferente
    }

   
    public function paciente()
    {
        return $this->belongsTo(Paciente::class); // Ajuste se o relacionamento for diferente
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}