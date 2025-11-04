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
        // Note: this requires doctrine/dbal to be installed to change column nullable.
        Schema::table('tarefas', function (Blueprint $table) {
            $table->integer('pontuacao')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->integer('pontuacao')->nullable(false)->change();
        });
    }
};
