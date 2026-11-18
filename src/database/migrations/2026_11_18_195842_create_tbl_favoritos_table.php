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
        Schema::create('tbl_favoritos', function (Blueprint $table) {
            $table->integer('id_favoritos', true);
            $table->integer('id_cliente');
            $table->integer('id_projetos')->index('tbl_favoritos_id_projetos_foreign');
            $table->dateTime('data_criacao_favoritos')->nullable();
            $table->dateTime('data_atualizacao_favoritos')->nullable();

            $table->unique(['id_cliente', 'id_projetos']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_favoritos');
    }
};
