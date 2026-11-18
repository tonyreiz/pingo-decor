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
        Schema::create('tbl_orcamento', function (Blueprint $table) {
            $table->integer('id_orcamento', true);
            $table->integer('id_cliente')->index('fk_orcamento_cliente');
            $table->string('titulo_orcamento', 50);
            $table->decimal('valor_total_orcamento', 10);
            $table->text('prazo_execucao_orcamento');
            $table->text('observacoes_orcamento');
            $table->string('status_orcamento', 10);
            $table->dateTime('data_criacao_orcamento')->useCurrent();
            $table->dateTime('data_atualizacao_orcamento')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_orcamento');
    }
};
