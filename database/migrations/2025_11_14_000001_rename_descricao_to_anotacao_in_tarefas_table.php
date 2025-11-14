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
        if (Schema::hasTable('tarefas') && Schema::hasColumn('tarefas', 'descricao')) {
            Schema::table('tarefas', function (Blueprint $table) {
                // Nota: renameColumn pode requerer doctrine/dbal em alguns ambientes.
                $table->renameColumn('descricao', 'anotacao');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('tarefas') && Schema::hasColumn('tarefas', 'anotacao')) {
            Schema::table('tarefas', function (Blueprint $table) {
                $table->renameColumn('anotacao', 'descricao');
            });
        }
    }
};
