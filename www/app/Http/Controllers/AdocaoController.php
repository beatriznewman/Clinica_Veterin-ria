<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Exception;
use Illuminate\Support\Facades\Auth;

class AdocaoController extends Controller
{
    /**
     * Função para adotar um animal.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adotar(Request $request)
    {
        try {
            // Recupera o animal pelo ID fornecido
            $animal = Animal::find($request->input('animal_id'));
            
            if (!$animal) {
                return response()->json(['message' => 'Animal não encontrado'], 404);
            }

            // Verifica se o animal já foi adotado
            if ($animal->paciente_id !== null) {
                return response()->json(['message' => 'Animal já foi adotado'], 400);
            }

            // Recupera o paciente logado (usuário atual)
            $pacienteId = Auth::user()->paciente_id;

            // Se não houver paciente associado ao usuário, retorna erro
            if (!$pacienteId) {
                return response()->json(['message' => 'Usuário não tem um paciente associado'], 400);
            }

            // Atualiza o paciente_id do animal com o paciente logado
            $animal->paciente_id = $pacienteId;
            $animal->save();

            return response()->json(['message' => 'Adoção realizada com sucesso'], 200);
        } catch (Exception $e) {
            // Captura qualquer exceção e retorna erro 500 com detalhes
            return response()->json(['message' => 'Erro ao processar a adoção', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Lista todos os animais disponíveis para adoção (sem dono).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listarAnimaisSemDono()
    {
        // Busca animais que não têm dono (paciente_id é NULL)
        $animaisSemDono = Animal::whereNull('paciente_id')->get();

        return response()->json($animaisSemDono, 200);
    }
}
