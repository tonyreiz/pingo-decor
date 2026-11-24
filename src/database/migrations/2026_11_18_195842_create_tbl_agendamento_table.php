<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_agendamento', function (Blueprint $table) {
            $table->integer('id_agendamento', true);
            $table->integer('id_cliente')->index('fk_agendamento_cliente');
            $table->integer('id_funcionario')->index('fk_agendamento_funcionario');
            $table->date('dia_agendamento');
            $table->time('horario_agendamento');
            $table->string('status_agendamento', 50);
            $table->string('endereco_agendamento');
            $table->dateTime('data_criacao_agendamento')->useCurrent();
            $table->dateTime('data_atualizacao_agendamento')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_agendamento');
    }
};
