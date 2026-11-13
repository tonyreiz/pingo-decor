<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('tbl_formulario', 'id') && !Schema::hasColumn('tbl_formulario', 'id_formulario')) {
            Schema::table('tbl_formulario', function (Blueprint $table) {
                $table->renameColumn('id', 'id_formulario');
            });
        }

        if (!Schema::hasColumn('tbl_formulario', 'nome')) {
            Schema::table('tbl_formulario', function (Blueprint $table) {
                $table->string('nome')->nullable();
                $table->string('telefone', 20)->nullable();
                $table->string('endereco')->nullable();
                $table->string('profissao')->nullable();
                $table->string('tipo_projeto')->nullable();
                $table->decimal('metragem', 10, 2)->nullable();
                $table->string('prazo')->nullable();
                $table->text('descricao')->nullable();
                $table->text('observacoes')->nullable();
                $table->string('status_formulario', 30)->default('Novo');
                $table->timestamp('data_criacao_formulario')->nullable();
                $table->timestamp('data_atualizacao_formulario')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tbl_formulario', 'nome')) {
            Schema::table('tbl_formulario', function (Blueprint $table) {
                $table->dropColumn([
                    'nome', 'telefone', 'endereco', 'profissao', 'tipo_projeto',
                    'metragem', 'prazo', 'descricao', 'observacoes', 'status_formulario',
                    'data_criacao_formulario', 'data_atualizacao_formulario',
                ]);
            });
        }

        if (Schema::hasColumn('tbl_formulario', 'id_formulario') && !Schema::hasColumn('tbl_formulario', 'id')) {
            Schema::table('tbl_formulario', function (Blueprint $table) {
                $table->renameColumn('id_formulario', 'id');
            });
        }
    }
};
