<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Consulta;
use Carbon\Carbon;

class ConsultaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_agendar_consulta()
    {
        $veterinario = User::factory()->create();
        $paciente = Paciente::factory()->create();
        $user = User::factory()->create();
        $user->update(['paciente_id' => $paciente->id]);
        
        $this->actingAs($user);

        $data = [
            'data' => Carbon::now()->addDay()->toDateString(),
            'horario_inicio' => '10:00',
            'horario_fim' => '11:00',
            'paciente_id' => $user->paciente_id,
            'user_id' => $veterinario->id,
        ];


        // Faz a requisição para agendar a consulta
        $response = $this->post('/consultas', $data);

        // Verifica se a consulta foi agendada corretamente
        $response->assertStatus(302); // Verifica se houve redirecionamento após agendar a consulta
        $this->assertDatabaseHas('consultas', $data); // Verifica se os dados da consulta estão na tabela 'consultas'
    }

    public function test_update_informacao_for_consulta()
    {
        $veterinario = User::factory()->create();
        $paciente = Paciente::factory()->create();
        $user = User::factory()->create();
        $user->update(['paciente_id' => $paciente->id]);
        
        $this->actingAs($user);

        $consulta = Consulta::factory()->create(['paciente_id' => $user->paciente_id, 'user_id' => $veterinario->id]);


        $informacao = 'Nova informação para consulta';

        $response = $this->putJson("/consultas/{$consulta->id}", ['informacao' => $informacao]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Informação atualizada com sucesso']);

        // Verifica se a informação foi realmente atualizada no banco de dados
        $this->assertDatabaseHas('consultas', [
            'id' => $consulta->id,
            'informacao' => $informacao,
        ]);
    }
}
