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
                'descricao' => 'Um cachorro leal e protetor.',
                'imagem' => 'animais/rex.jpg',
            ],
            [
                'especie' => 'Gato',
                'nome' => 'Mimi',
                'descricao' => 'Uma gata curiosa e brincalhona.',
                'imagem' => 'animais/mimi.jpg',
            ],
            [
                'especie' => 'Pássaro',
                'nome' => 'Loro',
                'descricao' => 'Um papagaio falante e esperto.',
                'imagem' => 'animais/loro.jpg',
            ],
            [
                'especie' => 'Hamster',
                'nome' => 'Pipoca',
                'descricao' => 'Um pequeno roedor adorável.',
                'imagem' => 'animais/pipoca.jpg',
            ],
            [
                'especie' => 'Gato',
                'nome' => 'Felix',
                'descricao' => 'Um gato elegante e independente.',
                'imagem' => 'animais/felix.jpg',
            ],
        ];

        // Cria os animais no banco de dados
        foreach ($animals as $animal) {
            Animal::create([
                'especie' => $animal['especie'],
                'nome' => $animal['nome'],
                'descricao' => $animal['descricao'],
                'paciente_id' => $pacientes->random()->paciente_id, // Atribui um paciente aleatório
                'imagem' => $animal['imagem'],
            ]);
        }
    }
}
