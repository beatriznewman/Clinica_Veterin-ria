<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdocaoSolicitacao;
use App\Models\Animal;
use Illuminate\Support\Facades\Log;

class AdocaoController extends Controller
{
    // Cliente envia solicitação de adoção
    public function solicitarAdocao(Request $request)
    {
        // Verifica se o cliente está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        // Verifica se o animal existe
        $animal = Animal::findOrFail($request->animal_id);

        // Verifica se o animal já tem um dono (paciente_id)
        if ($animal->paciente_id) {
            return response()->json(['error' => 'Este animal já foi adotado.'], 400);
        }

        // Cria a solicitação de adoção
        try {
            $solicitacao = AdocaoSolicitacao::create([
                'animal_id' => $animal->id,
                'cliente_id' => auth()->id(), // ID do cliente logado
                'status' => 'em_analise' // Status inicial
            ]);

            // Log para verificação
            Log::info('Solicitação de adoção criada com sucesso.', ['solicitacao_id' => $solicitacao->id]);

            return response()->json(['message' => 'Solicitação de Adoção enviada com sucesso.']);
        } catch (\Exception $e) {
            Log::error('Erro ao criar solicitação de adoção:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao enviar solicitação.'], 500);
        }
    }

    // Secretária visualiza solicitações de adoção
    public function listarSolicitacoes()
    {
        // Pega as solicitações com status "em_analise" junto com as informações de animal e cliente
        $solicitacoes = AdocaoSolicitacao::with(['animal', 'cliente'])
            ->where('status', 'em_analise')
            ->get();

        return response()->json($solicitacoes); // Retorna em formato JSON para o frontend
    }

    // Secretária confirma ou nega a adoção
    public function atualizarSolicitacao(Request $request, $id)
    {
        // Valida o status recebido
        $request->validate([
            'status' => 'required|in:confirmado,negado',
        ]);

        // Encontra a solicitação de adoção pelo ID
        $solicitacao = AdocaoSolicitacao::findOrFail($id);

        // Atualiza o status
        $solicitacao->status = $request->status;

        // Se a solicitação for confirmada, atualiza o animal com o ID do cliente
        if ($request->status == 'confirmado') {
            $animal = Animal::findOrFail($solicitacao->animal_id);

            // Verifica se o animal já foi adotado
            if ($animal->paciente_id) {
                return response()->json(['error' => 'Este animal já foi adotado.'], 400);
            }

            // Atualiza o paciente_id (cliente que adotou o animal)
            $animal->paciente_id = $solicitacao->cliente_id;
            $animal->save();
        }

        // Salva a solicitação com o novo status
        $solicitacao->save();

        return response()->json(['message' => 'Solicitação atualizada com sucesso.']);
    }

    // Cliente visualiza suas solicitações
    public function listarSolicitacoesCliente()
    {
        // Pega as solicitações do cliente autenticado e os dados do animal
        $solicitacoes = AdocaoSolicitacao::with('animal')
            ->where('cliente_id', auth()->id())
            ->get();

        return view('cliente.solicitacoes-adocao', compact('solicitacoes'));
    }
}
