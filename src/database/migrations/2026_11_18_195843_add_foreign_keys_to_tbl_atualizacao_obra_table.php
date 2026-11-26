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
        Schema::table('tbl_atualizacao_obra', function (Blueprint $table) {
            $table->foreign(['id_funcionario'])->references(['id_funcionario'])->on('tbl_funcionario')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_projetos'])->references(['id_projetos'])->on('tbl_projetos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_atualizacao_obra', function (Blueprint $table) {
            $table->dropForeign('tbl_atualizacao_obra_id_funcionario_foreign');
            $table->dropForeign('tbl_atualizacao_obra_id_projetos_foreign');
        });
    }
};
