<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Paciente extends Authenticatable
{
    use HasFactory;

    protected $table = 'pacientes';
    protected $fillable = ['nome', 'cep', 'endereco','bairro','cidade','estado','telefone'];

    public function user()
    {
        return $this->hasOne(User::class, 'paciente_id');
    }

    public function consulta()
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }
<<<<<<< HEAD

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

=======
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
}


