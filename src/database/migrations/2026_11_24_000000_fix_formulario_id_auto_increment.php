<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->ensureAutoIncrementPrimaryKey('tbl_formulario', 'id_formulario');
        $this->ensureAutoIncrementPrimaryKey('migrations', 'id');
    }

    public function down(): void
    {
        // Keep the table keys intact; removing auto-increment could prevent new submissions.
    }

    private function ensureAutoIncrementPrimaryKey(string $table, string $column): void
    {
        $details = DB::selectOne(
            'SELECT c.EXTRA AS extra, EXISTS (
                SELECT 1 FROM information_schema.STATISTICS s
                WHERE s.TABLE_SCHEMA = DATABASE()
                  AND s.TABLE_NAME = ?
                  AND s.INDEX_NAME = "PRIMARY"
                  AND s.COLUMN_NAME = ?
            ) AS is_primary
            FROM information_schema.COLUMNS c
            WHERE c.TABLE_SCHEMA = DATABASE()
              AND c.TABLE_NAME = ?
              AND c.COLUMN_NAME = ?',
            [$table, $column, $table, $column]
        );

        if (!$details) {
            throw new RuntimeException("Column {$table}.{$column} was not found.");
        }

        $changes = [];

        if (!str_contains(strtolower($details->extra), 'auto_increment')) {
            $changes[] = "MODIFY `{$column}` INT UNSIGNED NOT NULL AUTO_INCREMENT";
        }

        if (!(bool) $details->is_primary) {
            $changes[] = "ADD PRIMARY KEY (`{$column}`)";
        }

        if ($changes !== []) {
            DB::statement("ALTER TABLE `{$table}` " . implode(', ', $changes));
        }
    }
};
