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
            'descricao' => 'required|string',
            'paciente_id' => 'nullable|exists:users,paciente_id', // Verifica se o paciente_id existe na tabela de usuários
            'imagem' => 'nullable|image|max:2048',
        ]);

        // Se uma imagem foi enviada
        if ($request->hasFile('imagem')) {
            // Processa a imagem e armazena no diretório 'animais' (você pode mudar o diretório)
            $path = $request->file('imagem')->store('animais', 'public');

            // Adiciona o caminho da imagem aos dados
            $validatedData['imagem'] = $path;
        }

        $animal = Animal::create($validatedData);
        return response()->json($animal, 201);
    }
    
    public function hasAnimals(Request $request)
    {
        $pacienteId = $request->user()->paciente_id;
        $hasAnimals = Animal::where('paciente_id', $pacienteId)->exists();
        return response()->json(['hasAnimals' => $hasAnimals]);
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
            'descricao' => 'sometimes|required|string|max:255',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $animal = Animal::findOrFail($id);

        // Se uma nova imagem for enviada
        if ($request->hasFile('imagem')) {
            // Apaga a imagem antiga (caso exista)
            if ($animal->imagem) {
                Storage::disk('public')->delete($animal->imagem);
            }

            // Processa e armazena a nova imagem
            $path = $request->file('imagem')->store('animais', 'public');
            $animal->imagem = $path; // Atualiza o campo de imagem
        }

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

    public function animaisSemDono()
    {
        $animaisSemDono = Animal::whereNull('paciente_id')->get();
        return response()->json($animaisSemDono);
    }

}
