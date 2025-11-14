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
        Schema::table('tarefas', function (Blueprint $table) {
            if (!Schema::hasColumn('tarefas', 'itens')) {
                $table->json('itens')->nullable();
            }
            if (!Schema::hasColumn('tarefas', 'extras')) {
                $table->json('extras')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarefas', function (Blueprint $table) {
            if (Schema::hasColumn('tarefas', 'extras')) {
                $table->dropColumn('extras');
            }
            if (Schema::hasColumn('tarefas', 'itens')) {
                $table->dropColumn('itens');
            }
        });
    }
};
