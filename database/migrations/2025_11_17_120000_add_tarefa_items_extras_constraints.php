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
        $maxItens = env('TAREFA_MAX_ITENS', 10);
        $maxExtras = env('TAREFA_MAX_EXTRAS', 5);
        $enabled = env('TAREFA_CHECK_CONSTRAINTS_ENABLED', true);

        if (!$enabled) {
            // Skip constraints caso não estiverem habilitados
            return;
        }

        // Normalização converter valores não-array para arrays e truncar arrays maiores que o limite
        // 1) Converte valores JSON não-array em array contendo o valor (por exemplo a string -> ["string"]).
        DB::statement("UPDATE tarefas SET itens = json_build_array(itens) WHERE itens IS NOT NULL AND json_typeof(itens) IS DISTINCT FROM 'array'");
        DB::statement("UPDATE tarefas SET extras = json_build_array(extras) WHERE extras IS NOT NULL AND json_typeof(extras) IS DISTINCT FROM 'array'");

        // 2) Trunca arrays maiores que o limite, mantendo somente os primeiros N elementos
        DB::statement("UPDATE tarefas SET itens = (SELECT json_agg(val) FROM (SELECT value AS val, row_number() OVER () AS rn FROM json_array_elements(itens)) AS x WHERE rn <= $maxItens) WHERE json_typeof(itens) = 'array' AND json_array_length(itens) > $maxItens");
        DB::statement("UPDATE tarefas SET extras = (SELECT json_agg(val) FROM (SELECT value AS val, row_number() OVER () AS rn FROM json_array_elements(extras)) AS x WHERE rn <= $maxExtras) WHERE json_typeof(extras) = 'array' AND json_array_length(extras) > $maxExtras");

        // Remover constraints anteriores
        DB::statement('ALTER TABLE tarefas DROP CONSTRAINT IF EXISTS chk_tarefas_itens_count');
        DB::statement('ALTER TABLE tarefas DROP CONSTRAINT IF EXISTS chk_tarefas_extras_count');

        // Add novas constraints
        DB::statement("ALTER TABLE tarefas ADD CONSTRAINT chk_tarefas_itens_count CHECK (itens IS NULL OR (json_typeof(itens) = 'array' AND json_array_length(itens) <= $maxItens))");
        DB::statement("ALTER TABLE tarefas ADD CONSTRAINT chk_tarefas_extras_count CHECK (extras IS NULL OR (json_typeof(extras) = 'array' AND json_array_length(extras) <= $maxExtras))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE tarefas DROP CONSTRAINT IF EXISTS chk_tarefas_itens_count');
        DB::statement('ALTER TABLE tarefas DROP CONSTRAINT IF EXISTS chk_tarefas_extras_count');
    }
};
