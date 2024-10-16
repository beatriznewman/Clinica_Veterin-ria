<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consulta;
use App\Models\User;
use App\Models\Animal;
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

        // Cria as consultas no banco de dados
        foreach ($consultas as $consulta) {
            Consulta::create($consulta);
        }
    }
}