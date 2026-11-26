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
        Schema::create('tbl_projetos', function (Blueprint $table) {
            $table->integer('id_projetos', true);
            $table->string('nome_projetos', 30);
            $table->string('imagem_projetos', 65);
            $table->string('status_projetos', 10);
            $table->dateTime('data_criacao_projetos')->useCurrent();
            $table->dateTime('data_atualizacao_projetos')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_projetos');
    }
};
