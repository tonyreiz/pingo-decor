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
        Schema::create('tbl_atualizacao_obra', function (Blueprint $table) {
            $table->integer('id_atualizacao_obra', true);
            $table->integer('id_projetos')->index('tbl_atualizacao_obra_id_projetos_foreign');
            $table->integer('id_funcionario')->index('tbl_atualizacao_obra_id_funcionario_foreign');
            $table->text('descricao_atualizacao_obra');
            $table->string('imagem_atualizacao_obra')->nullable();
            $table->dateTime('data_criacao_atualizacao_obra')->nullable();
            $table->dateTime('data_atualizacao_atualizacao_obra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_atualizacao_obra');
    }
};
