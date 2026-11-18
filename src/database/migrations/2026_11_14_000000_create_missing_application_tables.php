<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tbl_funcionario')) {
            Schema::create('tbl_funcionario', function (Blueprint $table): void {
                $table->integer('id_funcionario')->autoIncrement();
                $table->primary('id_funcionario');
                $table->string('nome_funcionario', 50);
                $table->string('foto_funcionario', 255)->nullable();
                $table->string('email_funcionario', 80)->unique();
                $table->string('senha_funcionario');
                $table->string('cargo_funcionario', 20)->nullable();
                $table->string('status_funcionario', 10)->default('Ativo');
                $table->string('telefone_funcionario', 20)->nullable();
                $table->dateTime('data_criacao_funcionario')->nullable();
                $table->dateTime('data_atualizacao_funcionario')->nullable();
            });
        }

        if (!Schema::hasTable('tbl_agendamento')) {
            Schema::create('tbl_agendamento', function (Blueprint $table): void {
                $table->integer('id_agendamento')->autoIncrement();
                $table->primary('id_agendamento');
                $table->integer('id_cliente');
                $table->integer('id_funcionario');
                $table->date('dia_agendamento');
                $table->time('horario_agendamento');
                $table->string('endereco_agendamento', 255);
                $table->string('status_agendamento', 30)->default('Pendente');
                $table->foreign('id_cliente')->references('id_cliente')->on('tbl_cliente');
                $table->foreign('id_funcionario')->references('id_funcionario')->on('tbl_funcionario');
            });
        }

        if (!Schema::hasTable('tbl_favoritos')) {
            Schema::create('tbl_favoritos', function (Blueprint $table): void {
                $table->integer('id_favoritos')->autoIncrement();
                $table->primary('id_favoritos');
                $table->integer('id_cliente');
                $table->integer('id_projetos');
                $table->dateTime('data_criacao_favoritos')->nullable();
                $table->dateTime('data_atualizacao_favoritos')->nullable();
                $table->unique(['id_cliente', 'id_projetos']);
                $table->foreign('id_cliente')->references('id_cliente')->on('tbl_cliente');
                $table->foreign('id_projetos')->references('id_projetos')->on('tbl_projetos');
            });
        }

        if (!Schema::hasTable('tbl_atualizacao_obra')) {
            Schema::create('tbl_atualizacao_obra', function (Blueprint $table): void {
                $table->integer('id_atualizacao_obra')->autoIncrement();
                $table->primary('id_atualizacao_obra');
                $table->integer('id_projetos');
                $table->integer('id_funcionario');
                $table->text('descricao_atualizacao_obra');
                $table->string('imagem_atualizacao_obra', 255)->nullable();
                $table->dateTime('data_criacao_atualizacao_obra')->nullable();
                $table->dateTime('data_atualizacao_atualizacao_obra')->nullable();
                $table->foreign('id_projetos')->references('id_projetos')->on('tbl_projetos');
                $table->foreign('id_funcionario')->references('id_funcionario')->on('tbl_funcionario');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_atualizacao_obra');
        Schema::dropIfExists('tbl_favoritos');
        Schema::dropIfExists('tbl_agendamento');
        Schema::dropIfExists('tbl_funcionario');
    }
};
