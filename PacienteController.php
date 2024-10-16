<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
<<<<<<< HEAD
=======

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules;
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PacienteController extends Controller
{
    public function create()
    {
<<<<<<< HEAD
        return Inertia::render('Paciente');
=======
        return Inertia::render('Cadastro');
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
        // Mensagens de validação
=======
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        $mensagens = [
            'nome.required' => 'O nome é obrigatório.',
            'cep.required' => 'O CEP é obrigatório.',
            'cep.size' => 'O CEP deve ter 8 caracteres.',
            'endereco.required' => 'O endereço é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'estado.required' => 'O estado é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone deve ter no máximo 15 caracteres.',
            'username.required' => 'O username é obrigatório.',
            'username.unique' => 'Este username já está em uso.',
            'password.required' => 'A password é obrigatória.',
<<<<<<< HEAD
            'password.min' => 'A password deve ter pelo menos 6 caracteres.',
        ];

        // Validação dos dados
=======
            'password.min' => 'A password deve ter pelo menos 6 caracteres.'
        ];

>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        $request->validate([
            'nome' => 'required|string|max:255',
            'cep' => 'required|string|size:8',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'telefone' => 'required|string|max:15',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|min:6',
        ], $mensagens);

        DB::beginTransaction();
        try {
<<<<<<< HEAD
            $paciente = Paciente::create($request->only([
                'nome', 'cep', 'endereco', 'bairro', 'cidade', 'estado', 'telefone'
            ]));
=======
            $paciente = Paciente::create([
                'nome' => $request->nome,
                'cep' => $request->cep,
                'endereco' => $request->endereco,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'telefone' => $request->telefone,
            ]);
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d

            $user = User::create([
                'nome' => $request->nome,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'paciente_id' => $paciente->id,
            ]);

            $user->assignRole('cliente');
<<<<<<< HEAD
            event(new Registered($user));

            DB::commit();
            return response()->json(['message' => 'Paciente cadastrado com sucesso!', 'paciente' => $paciente]);
=======

            event(new Registered($user));

            DB::commit();

            return response()->json(['message' => 'Paciente cadastrado com sucesso!']);
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar paciente.'], 500);
        }
    }

<<<<<<< HEAD
    public function storeind(Request $request)
    {
        // Mesma validação e lógica que a função store
        // ... (mesmo código)
=======
    public function index()
    {
        return Paciente::all();
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
    }

    public function update(Request $request, $id)
    {
<<<<<<< HEAD
        // Lógica de atualização de paciente
        // ... (mesmo código)
=======
        $mensagens = [
            'nome.required' => 'O nome é obrigatório.',
            'cep.required' => 'O cep é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone deve ter no máximo 15 caracteres.'
        ];

        $request->validate([
            'nome' => 'required|string|max:255',
            'cep' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',

        ], $mensagens);

        $paciente = Paciente::findOrFail($id);
        $paciente->nome = $request->nome;
        $paciente->cep = $request->cep;
        $paciente->endereco = $request->endereco;
        $paciente->bairro = $request->bairro;
        $paciente->cidade = $request->cidade;
        $paciente->estado = $request->estado;
        $paciente->telefone = $request->telefone;
        $paciente->save();

        return response()->json(['message' => 'Paciente atualizado com sucesso!']);
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
    }

    public function pacienteChegou(Request $request)
    {
<<<<<<< HEAD
        // Lógica para notificar que um paciente chegou
        // ... (mesmo código)
    }

    public function index()
{
    // Obtendo o ID do veterinário autenticado
    $veterinarioId = auth()->user()->id;

    // Buscando pacientes e seus animais relacionados a este veterinário
    $pacientes = Paciente::with('animais')->where('veterinario_id', $veterinarioId)->get();

    // Retornando os nomes dos pacientes e os nomes dos animais
    $resultado = $pacientes->map(function ($paciente) {
        return [
            'nome_paciente' => $paciente->nome,
            'animais' => $paciente->animais->pluck('nome'), // Obtendo apenas os nomes dos animais
        ];
    });

    return response()->json($resultado);
}
=======
        $pacienteId = $request->input('paciente_id');
        $pacienteNome = $request->input('paciente_nome');
        $psicologoId = $request->input('psicologo_id');
    
        Log::info("Recebido pacienteId: $pacienteId, pacienteNome: $pacienteNome, psicologoId: $psicologoId");
    
        if (!$pacienteId || !$pacienteNome) {
            Log::error('Dados de paciente incompletos');
            return response()->json(['message' => 'Dados de paciente incompletos'], 400);
        }
    
        try {
            $notificacoes = Cache::get('notificacoes', []);
            $notificacoes[] = "O paciente $pacienteNome chegou";
            Cache::put('notificacoes', $notificacoes, now()->addMinutes(5));
    
            Log::info('Notificação armazenada com sucesso');
            return response()->json(['message' => 'Notificação enviada ao psicólogo']);
        } catch (\Exception $e) {
            Log::error('Erro ao processar notificação: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao processar notificação'], 500);
        }
    } 

>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
}
