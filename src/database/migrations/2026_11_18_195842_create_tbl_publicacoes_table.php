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
        Schema::create('tbl_publicacoes', function (Blueprint $table) {
            $table->integer('id_publicacoes', true);
            $table->string('titulo_publicacoes', 100);
            $table->text('descricao_publicacoes');
            $table->string('imagem_publicacoes');
            $table->string('link_publicacoes');
            $table->dateTime('data_publicacoes');
            $table->dateTime('data_criacao_publicacoes')->useCurrent();
            $table->dateTime('data_atualizacao_publicacoes')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_publicacoes');
    }
};
