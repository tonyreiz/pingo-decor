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
        Schema::create('tbl_formulario', function (Blueprint $table) {
            $table->integer('id_formulario', true);
            $table->string('nome');
            $table->string('email');
            $table->string('telefone', 20);
            $table->string('endereco');
            $table->string('profissao')->nullable();
            $table->string('tipo_projeto');
            $table->decimal('metragem')->nullable();
            $table->string('prazo')->nullable();
            $table->text('descricao')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('status_formulario', 10)->default('pendente');
            $table->dateTime('data_criacao_formulario')->useCurrent();
            $table->dateTime('data_atualizacao_formulario')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_formulario');
    }
};
