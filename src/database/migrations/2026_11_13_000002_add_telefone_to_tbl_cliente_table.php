<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_cliente') && !Schema::hasColumn('tbl_cliente', 'telefone_cliente')) {
            Schema::table('tbl_cliente', function (Blueprint $table) {
                $table->string('telefone_cliente', 20)->nullable()->after('email_cliente');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tbl_cliente') && Schema::hasColumn('tbl_cliente', 'telefone_cliente')) {
            Schema::table('tbl_cliente', function (Blueprint $table) {
                $table->dropColumn('telefone_cliente');
            });
        }
    }
};
