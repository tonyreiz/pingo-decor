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
        Schema::create('tbl_contato', function (Blueprint $table) {
            $table->integer('id_contato', true);
            $table->string('nome_contato', 60);
            $table->string('nome_companheiro_contato', 70);
            $table->string('nome_idade_criancas_contato', 60);
            $table->string('email_contato', 80);
            $table->string('telefone_contato', 15);
            $table->string('cidade_bairro_contato', 32);
            $table->string('profissao_contato', 80);
            $table->string('origem_contato', 23);
            $table->string('ajuda_contato', 47);
            $table->string('metragem_contato', 70);
            $table->string('quantidades_ambientes_contato', 14);
            $table->string('trimestre_gestacao_contato', 37);
            $table->string('prazo_contato', 15);
            $table->string('detalhes_contato', 80);
            $table->dateTime('data_criacao_contato')->useCurrent();
            $table->dateTime('data_atualizacao_contato')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_contato');
    }
};
