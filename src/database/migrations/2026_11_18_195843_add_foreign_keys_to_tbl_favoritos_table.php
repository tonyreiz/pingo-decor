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
        Schema::table('tbl_favoritos', function (Blueprint $table) {
            $table->foreign(['id_cliente'])->references(['id_cliente'])->on('tbl_cliente')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_projetos'])->references(['id_projetos'])->on('tbl_projetos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_favoritos', function (Blueprint $table) {
            $table->dropForeign('tbl_favoritos_id_cliente_foreign');
            $table->dropForeign('tbl_favoritos_id_projetos_foreign');
        });
    }
};
