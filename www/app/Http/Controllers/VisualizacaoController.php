<?php

namespace App\Http\Controllers;

use App\Models\Animal;  // Importa o modelo Animal
use Illuminate\Http\Request;
use Inertia\Inertia;

class VisualizacaoController extends Controller
{
    public function index()
    {
        // Busca todos os animais com os dados dos donos (paciente), se houver
        $animals = Animal::with('paciente:id,nome')->get();

        // Retorna a página com os dados dos animais
        return Inertia::render('Animais', [
            'animals' => $animals
        ]);
    }   
}
