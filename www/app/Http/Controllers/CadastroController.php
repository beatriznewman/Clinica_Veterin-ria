<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'animal.nome' => 'required|string|max:255',
        'animal.especie' => 'required|string|max:255',
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

    $user = User::create([
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'role' => 'paciente',
    ]);

    $paciente = Paciente::create(array_merge($request->paciente, ['user_id' => $user->id]));

    if (isset($request->animal)) {
        foreach ($request->animal as $animal) {
            Animal::create($animal);
        }
    }

    return response()->json(['message' => 'Cadastro realizado com sucesso!']);
}

}
