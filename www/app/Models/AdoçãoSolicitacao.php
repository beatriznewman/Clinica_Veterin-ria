<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdocaoSolicitacao extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'cliente_id', 'secretaria_id', 'status'];

    // Relacionamento com o modelo de Animal
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    // Relacionamento com o modelo de Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
