<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tbl_formulario', 'email')) {
            Schema::table('tbl_formulario', function (Blueprint $table) {
                // Nullable to preserve existing submissions; new form entries require it.
                $table->string('email')->nullable()->after('telefone');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tbl_formulario', 'email')) {
            Schema::table('tbl_formulario', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }
};
