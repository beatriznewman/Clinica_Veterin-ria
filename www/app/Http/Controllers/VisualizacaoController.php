<?php

namespace App\Http\Controllers;

use App\Models\Animal;  // Importa o modelo Animal
use App\Models\Paciente;  // Importa o modelo Paciente
use Illuminate\Http\Request;
use Inertia\Inertia;

class VisualizacaoController extends Controller
{
    public function animal()
    {
        // Busca todos os animais com os dados dos donos (paciente), se houver
        $animals = Animal::with('paciente:id,nome')->get();

        // Retorna a página com os dados dos animais
        return Inertia::render('Animais', [
            'animals' => $animals
        ]);
    }   

    public function usuario()
    {
        // Busca todos os pacientes e verifica se possuem animais
        $pacientes = Paciente::with('animals:id,nome,paciente_id')->get();

        return Inertia::render('Usuario', [
            'pacientes' => $pacientes
        ]);
    }
}
