<?php
<<<<<<< HEAD
=======

>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consulta;
use App\Models\User;
<<<<<<< HEAD
use App\Models\Animal;
=======
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
use Carbon\Carbon;

class ConsultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        // Obtém todos os veterinários
        $veterinarios = User::role('veterinario')->get();
        
        // Obtém todos os pacientes (clientes)
        $pacientes = User::role('cliente')->get();

        $consultas = [];

        // Loop através de cada paciente
        foreach ($pacientes as $paciente) {
            // Obtém os animais associados ao paciente
            $animals = Animal::where('paciente_id', $paciente->paciente_id)->get();

            // Se o paciente tem animais, cria consultas
            if ($animals->isNotEmpty()) {
                foreach ($animals as $animal) {
                    // Adiciona múltiplas consultas para cada animal
                    $consultas[] = [
                        [
                            'user_id' => $veterinarios->random()->id,
                            'animal_id' => $animal->id, // Atribui o ID do animal
                            'data' => Carbon::parse('2024-10-01')->toDateString(), 
                            'horario_inicio' => '09:00',
                            'horario_fim' => '09:50',
                            'informacao' => null,
                        ], 
                        [
                            'user_id' => $veterinarios->random()->id,
                            'animal_id' => $animal->id, // Atribui o ID do animal
                            'data' => Carbon::parse('2024-12-01')->toDateString(), 
                            'horario_inicio' => '09:00',
                            'horario_fim' => '09:50',
                            'informacao' => null,
                        ], 
                        [
                            'user_id' => $veterinarios->random()->id,
                            'animal_id' => $animal->id, // Atribui o ID do animal
                            'data' => Carbon::parse('2024-10-09')->toDateString(), 
                            'horario_inicio' => '09:00',
                            'horario_fim' => '09:50',
                            'informacao' => null,
                        ],
                    ]; // Remova os colchetes adicionais aqui
                }
            }
        }
=======
        // Obtém todos os psicólogos
        $psicologos = User::role('psicologo')->get();
        
        // Supondo que há pacientes criados anteriormente, você pode pegar os IDs dos pacientes
        $pacientes = User::role('cliente')->get()->pluck('paciente_id')->toArray();

        // Dados de exemplo para as consultas
        $consultas = [
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-08-01')->toDateString(), 
                'horario_inicio' => '09:00',
                'horario_fim' => '9:50',
                'informacao' => null,
            ],
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-05-02')->toDateString(), 
                'horario_inicio' => '11:00',
                'horario_fim' => '11:50',
                'informacao' => 'Paciente liberado com sucesso.',
            ],
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-06-01')->toDateString(), 
                'horario_inicio' => '14:00',
                'horario_fim' => '14:50',
                'informacao' => null,
            ],
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-05-22')->toDateString(), 
                'horario_inicio' => '13:00',
                'horario_fim' => '13:50',
                'informacao' => 'O paciente deve retornar apos 15 dias para realizar uma nova sessao',
            ],
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-09-01')->toDateString(), 
                'horario_inicio' => '15:00',
                'horario_fim' => '15:50',
                'informacao' => null,
            ],
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-04-03')->toDateString(), 
                'horario_inicio' => '16:00',
                'horario_fim' => '16:50',
                'informacao' => 'Paciente deve retornar daqui 20 dias para realizar uma nova sessao',
            ],
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-07-01')->toDateString(), 
                'horario_inicio' => '17:00',
                'horario_fim' => '17:50',
                'informacao' => null,
            ],
            [
                'user_id' => $psicologos->random()->id,
                'paciente_id' => $pacientes[array_rand($pacientes)],
                'data' => Carbon::parse('2024-06-02')->toDateString(), 
                'horario_inicio' => '08:00',
                'horario_fim' => '08:50',
                'informacao' => null,
            ],
        ];
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d

        // Cria as consultas no banco de dados
        foreach ($consultas as $consulta) {
            Consulta::create($consulta);
        }
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
