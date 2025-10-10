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
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dev_id')->constrained()->onDelete('cascade');
            $table->integer('numero_semana'); // Num da semana (ex.: 32, 33)
            $table->string('nome_tarefa'); // Nome da tarefa
            $table->text('descricao')->nullable(); // Descrição (opcional)
            $table->integer('pontuacao'); // Pontuação (0, 2, 3, 5, 8)
            $table->date('data_inicio'); // Data de início
            $table->date('data_fim')->nullable(); // Data de fim (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
