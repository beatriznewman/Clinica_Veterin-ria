<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdocaoSolicitacoesTable extends Migration
{
    public function up()
    {
        Schema::create('adocao_solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('animal_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('secretaria_id')->nullable(); // Secretária que confirma ou nega
            $table->string('status')->default('em_analise'); // Status: em_analise, confirmado, negado
            $table->timestamps();

            // Definindo as chaves estrangeiras
            $table->foreign('animal_id')->references('id')->on('animais')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adocao_solicitacoes');
    }
};
