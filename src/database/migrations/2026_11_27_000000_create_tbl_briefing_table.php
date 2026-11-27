<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_briefing', function (Blueprint $table): void {
            $table->increments('id_briefing');
            // Match tbl_projetos.id_projetos, which is a signed integer.
            $table->integer('id_projetos')->unique();
            $table->json('conteudo_briefing');
            $table->dateTime('data_criacao_briefing')->nullable();
            $table->dateTime('data_atualizacao_briefing')->nullable();
            $table->foreign('id_projetos')->references('id_projetos')->on('tbl_projetos')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_briefing');
    }
};
