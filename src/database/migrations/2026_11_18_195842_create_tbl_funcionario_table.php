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
        Schema::create('tbl_funcionario', function (Blueprint $table) {
            $table->integer('id_funcionario', true);
            $table->string('nome_funcionario');
            $table->string('email_funcionario')->unique('uq_funcionario_email');
            $table->string('telefone_funcionario', 20);
            $table->string('senha_funcionario');
            $table->string('foto_funcionario');
            $table->string('cargo_funcionario', 100);
            $table->string('status_funcionario', 50)->default('Ativo');
            $table->dateTime('data_criacao_funcionario')->nullable()->useCurrent();
            $table->dateTime('data_atualizacao_funcionario')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_funcionario');
    }
};
