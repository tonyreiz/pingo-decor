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
        Schema::table('tbl_agendamento', function (Blueprint $table) {
            $table->foreign(['id_cliente'], 'fk_agendamento_cliente')->references(['id_cliente'])->on('tbl_cliente')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['id_funcionario'], 'fk_agendamento_funcionario')->references(['id_funcionario'])->on('tbl_funcionario')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_agendamento', function (Blueprint $table) {
            $table->dropForeign('fk_agendamento_cliente');
            $table->dropForeign('fk_agendamento_funcionario');
        });
    }
};
