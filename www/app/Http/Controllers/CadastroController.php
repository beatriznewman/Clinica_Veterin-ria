<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    protected $pacienteController;
    protected $animalController;

    public function __construct(PacienteController $pacienteController, AnimalController $animalController)
    {
        $this->pacienteController = $PacienteController;
        $this->animalController = $AnimalController;
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal' => 'required|array',
            'animal.*.nome' => 'required|string|max:255',
            'animal.*.especie' => 'required|string|max:255',
            'paciente.nome' => 'required|string|max:255',
            'paciente.cep' => 'required|string|max:10',
            'paciente.endereco' => 'required|string|max:255',
            'paciente.bairro' => 'required|string|max:255',
            'paciente.cidade' => 'required|string|max:255',
            'paciente.estado' => 'required|string|max:2',
            'paciente.telefone' => 'required|string|max:15',
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Criar o usuário
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'paciente',
        ]);

        $pacienteData = array_merge($request->paciente, ['user_id' => $user->id]);
        $paciente = $this->pacienteController->storePaciente($pacienteData);

        foreach ($request->animal as $animal) {
            $animalData = array_merge($animal, ['paciente_id' => $paciente->id]);
            $this->animalController->storeAnimal($animalData); 
        }
        return redirect()->route('animais-pacientes.store')->json(['message' => 'Cadastro realizado com sucesso!']);
    }
}
