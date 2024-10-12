<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'especie' => 'required|string',
            'nome' => 'required|string',
            'paciente_id' => 'nullable|exists:pacientes,id',
        ]);

        // Criação do animal
        $animal = new Animal();
        $animal->especie = $request->input('especie');
        $animal->nome = $request->input('nome');
        $animal->paciente_id = $request->input('paciente_id'); // Pode ser null
        $animal->save();

        return response()->json([
            'message' => 'Animal cadastrado com sucesso!',
            'animal' => $animal
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'especie' => 'required|string',
            'nome' => 'required|string',
            'paciente_id' => 'nullable|exists:pacientes,id',
        ]);

        // Atualização do animal
        $animal = Animal::findOrFail($id);
        $animal->especie = $request->input('especie');
        $animal->nome = $request->input('nome');
        $animal->paciente_id = $request->input('paciente_id'); // Pode ser null
        $animal->save();

        return response()->json([
            'message' => 'Animal atualizado com sucesso!',
            'animal' => $animal
        ], 200);
    }
}
