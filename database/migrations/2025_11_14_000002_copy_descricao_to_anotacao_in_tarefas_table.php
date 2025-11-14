<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tarefas')) {
            return;
        }

        // Se não existir a coluna anotacao, criá-la
        if (!Schema::hasColumn('tarefas', 'anotacao')) {
            Schema::table('tarefas', function (Blueprint $table) {
                $table->text('anotacao')->nullable();
            });
        }

        // Se existir descricao, copiar os valores para anotacao (somente quando anotacao estiver vazia)
        if (Schema::hasColumn('tarefas', 'descricao')) {
            // Usar statement para compatibilidade entre DBs
            DB::statement('UPDATE tarefas SET anotacao = descricao WHERE (anotacao IS NULL OR anotacao = "")');
        }

        // Não removemos 'descricao' para evitar necessidade de doctrine/dbal e riscos em ambientes diferentes.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não removemos automaticamente a coluna anotacao no down para evitar perda de dados.
        // Se desejar reverter, é possível criar manualmente uma migration para copiar de volta e dropar.
    }
};
