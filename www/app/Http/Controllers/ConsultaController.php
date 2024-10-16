<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use App\Models\Consulta;
use App\Models\User;
use App\Models\Animal;
use Inertia\Inertia;
use Carbon\Carbon;
=======
use App\Models\Consulta;
use App\Models\User;
use Inertia\Inertia;
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d

class ConsultaController extends Controller
{
    public function create()
<<<<<<< HEAD
    {
        $user = auth()->user();

        $users = User::role('veterinario')->get(); // retorna todos os usuários com a role 'veterinario'
        
        $animals = Animal::where('paciente_id', $user->paciente_id)->get();

        return Inertia::render('AgendarConsulta', [
            'users' => $users,
            'animals' => $animals,
            'success' => session('success'),
            'error' => session('error')
=======
    {    
        $users = User::role('psicologo')->get(); // retorna todos os user que tem role 'psicologo'
        
        return Inertia::render('AgendarConsulta', [
            'users' => $users,
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        ]);
    }

    public function store(Request $request)
    {
        // Validar os dados do formulário
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
<<<<<<< HEAD
            'animal_id' => 'required|exists:animals,id',
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i',
        ]);

        // Verificação de dias úteis
        $dataConsulta = Carbon::parse($request->data);
        if ($dataConsulta->isWeekend()) {
            return redirect()->back()->withInput()->withErrors(['error' => 'A consulta deve ser agendada em um dia útil.']);
        }

        // Verificação de horários permitidos
        $horarioInicio = Carbon::createFromFormat('H:i', $request->horario_inicio);
        $horarioFim = Carbon::createFromFormat('H:i', $request->horario_fim);
        $inicioPermitido = Carbon::createFromTime(8, 0);  // 08:00
        $fimPermitido = Carbon::createFromTime(20, 0);    // 20:00
        
        if ($horarioInicio->lt($inicioPermitido) || $horarioFim->gt($fimPermitido)) {
            return redirect()->back()->withInput()->withErrors(['error' => 'O horário da consulta deve estar entre 08:00 e 20:00.']);
        }

        // Verifica se já existe uma consulta para o mesmo horário
        $existente = Consulta::where('user_id', $validated['user_id'])
            ->where('data', $validated['data'])
            ->where(function ($query) use ($horarioInicio, $horarioFim) {
                $query->whereBetween('horario_inicio', [$horarioInicio, $horarioFim])
                      ->orWhereBetween('horario_fim', [$horarioInicio, $horarioFim]);
            })
            ->exists();

        if ($existente) {
            return redirect()->back()->withInput()->withErrors(['error' => 'O horário selecionado já está ocupado.']);
        }

        // Verificando se já existe uma consulta agendada para o mesmo paciente e no mesmo horário
        $existentepaciente = Consulta::where('paciente_id', auth()->user()->paciente_id) // Verifica pelo paciente logado
            ->where('data', $validated['data'])
            ->where(function ($query) use ($horarioInicio, $horarioFim) {
                $query->whereBetween('horario_inicio', [$horarioInicio, $horarioFim])
                    ->orWhereBetween('horario_fim', [$horarioInicio, $horarioFim])
                    ->orWhere(function ($query) use ($horarioInicio, $horarioFim) {
                        $query->where('horario_inicio', '<=', $horarioInicio)
                                ->where('horario_fim', '>=', $horarioFim);
                    });
            })
            ->exists();

        if ($existentepaciente) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Você já possui uma consulta agendada neste horário.']);
=======
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i',
            'informacao' => 'nullable|date_format:H:i',
        ]);

        // Verificar se o psicólogo está disponível nesse horário
        $horarioInicio = \Carbon\Carbon::createFromFormat('H:i', $request->horario_inicio);
        $horarioFim = \Carbon\Carbon::createFromFormat('H:i', $request->horario_fim);

        $consultaExistente = Consulta::where('user_id', $request->user_id)
                                    ->where('data', $request->data)
                                    ->where(function ($query) use ($horarioInicio, $horarioFim) {
                                        $query->where(function ($q) use ($horarioInicio, $horarioFim) {
                                            $q->where('horario_inicio', '<=', $horarioInicio)
                                              ->where('horario_fim', '>', $horarioInicio);
                                        })
                                        ->orWhere(function ($q) use ($horarioInicio, $horarioFim) {
                                            $q->where('horario_inicio', '<', $horarioFim)
                                              ->where('horario_fim', '>=', $horarioFim);
                                        });
                                    })
                                    ->exists();

        if ($consultaExistente) {
            return redirect()->back()->withInput()->with('error', 'Psicólogo já está ocupado nesse horário.');
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        }

        // Criar uma nova consulta
        Consulta::create([
            'paciente_id' => auth()->user()->paciente_id,// Utiliza o ID do paciente logado
            'user_id' => $request->user_id,
<<<<<<< HEAD
            'animal_id' => $request->animal_id,
=======
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
            'data' => $request->data,
            'horario_inicio' => $request->horario_inicio,
            'horario_fim' => $request->horario_fim,
            'informacao'=>null,
        ]);

<<<<<<< HEAD
        return redirect()->route('consultas.create')->with('success', 'Consulta agendada com sucesso!');
    }
    
    public function historico(Request $request)
    {
        // Data e hora atual
        $now = now();
    
        // Obtém o ID do animal a partir da requisição
        $animalId = $request->input('animal_id');
    
        // Obtém as consultas do paciente logado, com os dados completos do veterinário e do animal
        $consultas = Consulta::where('paciente_id', auth()->user()->paciente_id)
            ->with(['user', 'animal']) // Carrega o relacionamento com o veterinário e o animal
            ->when($animalId, function ($query) use ($animalId) {
                return $query->where('animal_id', $animalId); // Filtra pelas consultas do animal selecionado
            })
            ->where(function ($query) use ($now) {
                $query->where('data', '<', $now->toDateString()) // Consultas anteriores ao dia de hoje
                    ->orWhere(function ($query) use ($now) {
                        $query->where('data', '=', $now->toDateString())
                            ->where('horario_inicio', '<=', $now->toTimeString());
                    });
            })
            ->orderBy('data', 'asc')
            ->orderBy('horario_inicio', 'asc')
            ->get();
    
        // Obter todos os animais do paciente logado
        $animals = Animal::where('paciente_id', auth()->user()->paciente_id)->get();
    
        return Inertia::render('HistoricoConsultas', [
            'consultas' => $consultas,
            'animals' => $animals, // Passa os animais para o frontend
            'selected_animal_id' => $animalId
        ]);
    }
    

public function consultar(Request $request)
{
    // Data e hora atual
    $now = now();

    // Obtém o ID do paciente a partir da requisição
    $pacienteId = auth()->user()->paciente_id;

    // Obtém todos os animais do paciente logado
    $animals = Animal::where('paciente_id', $pacienteId)->get();

    // Inicia a consulta
    $query = Consulta::where('paciente_id', $pacienteId)
                    ->with(['user', 'animal']) // Carrega o relacionamento com o veterinário e o animal
                    ->where(function ($query) use ($now) {
                        $query->where('data', '>', $now->toDateString())
                              ->orWhere(function ($query) use ($now) {
                                  $query->where('data', '=', $now->toDateString())
                                        ->where('horario_inicio', '>=', $now->toTimeString());
                              });
                    });

    // Se um animal_id foi fornecido, aplique o filtro
    $animalId = $request->input('animal_id');
    if ($animalId) {
        $query->where('animal_id', $animalId);
    }

    // Ordena e obtém as consultas
    $consultas = $query->orderBy('data', 'asc')
                       ->orderBy('horario_inicio', 'asc')
                       ->get();

    return Inertia::render('ConsultasFuturas', [
        'consultas' => $consultas,
        'animals' => $animals, // Passa os animais para o frontend
        'selected_animal_id' => $animalId
    ]);
}

public function index()
{
    $consultas = Consulta::where('user_id', auth()->user()->id)
                        ->with(['paciente', 'animal']) // Carrega os relacionamentos paciente e animal
                        ->get();
    return response()->json($consultas);
}

    public function update(Request $request, $id)
    {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
=======
        // Redirecionar após a criação da consulta
        return redirect()->route('consultas.create')->with('success', 'Consulta agendada com sucesso!');
    }

    public function historico()
    {
        // Data e hora atual
        $now = now();

        // Obtém as consultas do paciente logado, com os dados completos do psicólogo
        $consultas = Consulta::where('paciente_id', auth()->user()->paciente_id)
                            ->with('user') // Carrega o relacionamento psicologo
                            ->where('data', '<', $now->toDateString()) // Consultas anteriores ao dia de hoje
                            ->orWhere(function ($query) use ($now) {
                                $query->where('data', '=', $now->toDateString())
                                    ->where('horario_inicio', '<=', $now->toTimeString());
                            })
                            ->orderBy('data', 'asc')
                            ->orderBy('horario_inicio', 'asc')
                            ->get();

        return Inertia::render('HistoricoConsultas', [
            'consultas' => $consultas,
        ]);
    }

    public function consultar()
    {
        // Data e hora atual
        $now = now();

        // Obtém as consultas do paciente logado, com os dados completos do psicólogo
        $consultas = Consulta::where('paciente_id', auth()->user()->paciente_id)
                            ->with('user') // Carrega o relacionamento psicologo
                            ->where('data', '>', $now->toDateString()) // Consultas anteriores ao dia de hoje
                            ->orWhere(function ($query) use ($now) {
                                $query->where('data', '=', $now->toDateString())
                                    ->where('horario_inicio', '>=', $now->toTimeString());
                            })
                            ->orderBy('data', 'asc')
                            ->orderBy('horario_inicio', 'asc')
                            ->get();

        return Inertia::render('ConsultasFuturas', [
            'consultas' => $consultas,
        ]);
    }

    public function index()
    {
        $consultas = Consulta::where('user_id', auth()->user()->id)
                            ->with('paciente') // Carrega o relacionamento paciente
                            ->get();
        return response()->json($consultas);
    }

    public function update(Request $request, $id)
    {
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        $validated = $request->validate([
            'informacao' => 'nullable|string',
        ]);

        $consulta = Consulta::findOrFail($id);
        $consulta->informacao = $validated['informacao'];
        $consulta->save();

        return response()->json(['message' => 'Informação atualizada com sucesso']);
    }

    public function allConsultas()
    {
        $consultas = Consulta::with(['paciente', 'user'])->get();
        return response()->json($consultas);
    }
    
}
