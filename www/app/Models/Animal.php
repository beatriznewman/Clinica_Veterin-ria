<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animais';
    protected $fillable = ['especie', 'nome'];

    public function user()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function consulta()
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }
}





