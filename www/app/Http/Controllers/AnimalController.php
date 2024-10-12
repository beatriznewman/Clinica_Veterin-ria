<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Paciente;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function create()
    {
        // Pega todos os tutores (pacientes) disponíveis para o dropdown
        $tutores = Paciente::whereNotNull('id')->pluck('username', 'id'); // Altere conforme o campo que você deseja

        return view('cadastro-animal', compact('tutores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'especie' => 'required|string',
            'nome' => 'required|string',
            'paciente_id' => 'nullable|exists:users,paciente_id', // Verifica se o paciente_id existe na tabela de usuários
        ]);

        $animal = Animal::create($validatedData);
        return response()->json($animal, 201);
    }


    public function index()
    {
        
        $animais = Animal::all(); 
        return response()->json($animais);
    }

    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        return response()->json($animal);
    }

    // Método para atualizar um animal
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'especie' => 'sometimes|required|string|max:255',
            'paciente_id' => 'nullable|exists:pacientes,id',
        ]);

        $animal = Animal::findOrFail($id);
        $animal->update($request->all());
        return response()->json($animal);
    }

    // Método para deletar um animal
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();
        return response()->json(['message' => 'Animal deletado com sucesso.']);
    }

}
