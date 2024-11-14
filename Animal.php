<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animals';
    protected $fillable = ['nome', 'especie', 'paciente_id', 'imagem'];

    // Relacionamento com Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function consulta()
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }

    // Relação entre Animal e Paciente (dono do animal)
    public function dono()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }   
}




