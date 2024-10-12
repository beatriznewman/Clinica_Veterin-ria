<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Consulta;
use App\Models\User;
use Inertia\Inertia;
use Carbon\Carbon;

class ConsultaController extends Controller
{
    public function create()
    {
        $users = User::role('veterinario')->get(); // retorna todos os usuários com a role 'veterinario'
        
        return Inertia::render('AgendarConsulta', [
            'users' => $users,
            'success' => session('success'),
            'error' => session('error')
        ]);
    }

    public function store(Request $request)
    {
        // Validar os dados do formulário
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
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
        }

        // Criar uma nova consulta
        Consulta::create([
            'paciente_id' => auth()->user()->paciente_id,// Utiliza o ID do paciente logado
            'user_id' => $request->user_id,
            'data' => $request->data,
            'horario_inicio' => $request->horario_inicio,
            'horario_fim' => $request->horario_fim,
            'informacao'=>null,
        ]);

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
