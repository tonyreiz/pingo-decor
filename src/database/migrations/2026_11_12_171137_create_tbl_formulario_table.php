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
            $table->id('id_formulario');
            $table->string('nome');
            $table->string('telefone', 20);
            $table->string('email');
            $table->string('endereco');
            $table->string('profissao')->nullable();
            $table->string('tipo_projeto');
            $table->decimal('metragem', 10, 2)->nullable();
            $table->string('prazo')->nullable();
            $table->text('descricao')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('status_formulario', 30)->default('Novo');
            $table->timestamp('data_criacao_formulario')->nullable();
            $table->timestamp('data_atualizacao_formulario')->nullable();
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
