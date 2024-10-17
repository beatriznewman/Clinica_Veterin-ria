<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Consulta;
use App\Models\User;
use App\Models\Animal;
use Carbon\Carbon;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtém todos os pacientes (clientes)
        $pacientes = User::role('cliente')->get();

        // Dados de exemplo para os animais
        $animals = [
            [
                'especie' => 'Cachorro',
                'nome' => 'Rex',
            ],
            [
                'especie' => 'Gato',
                'nome' => 'Mimi',
            ],
            [
                'especie' => 'Pássaro',
                'nome' => 'Loro',
            ],
            [
                'especie' => 'Hamster',
                'nome' => 'Pipoca',
            ],
            [
                'especie' => 'Gato',
                'nome' => 'Felix',
            ],
        ];

        // Cria os animais no banco de dados
        foreach ($animals as $animal) {
            Animal::create([
                'especie' => $animal['especie'],
                'nome' => $animal['nome'],
                'paciente_id' => $pacientes->random()->paciente_id, // Atribui um paciente aleatório
            ]);
        }
    }
}
