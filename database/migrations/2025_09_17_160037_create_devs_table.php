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
        Schema::create('devs', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Nome do dev
            $table->string('cargo'); // Cargo do dev
            $table->string('email')->nullable(); // Email (opcional)
            $table->date('data_inicio')->nullable(); // Data de início da experiência (opcional)
            $table->string('avatar')->nullable(); // URL do avatar (opcional)
            $table->string('faixa')->nullable(); // Faixa do dev (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devs');
    }
};
