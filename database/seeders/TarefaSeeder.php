<?php

namespace Database\Seeders;

use App\Models\Dev;
use App\Models\Tarefa;
use Illuminate\Database\Seeder;

class TarefaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obter os devs criados
        $devs = Dev::all();
        
        if ($devs->count() > 0) {
            // Semanas recentes
            $semanaAtual = date('W');
            
            // Criar tarefas para cada dev
            foreach ($devs as $dev) {
                // Tarefa da semana atual
                Tarefa::create([
                    'dev_id' => $dev->id,
                    'numero_semana' => $semanaAtual,
                    'nome_tarefa' => 'Implementar nova funcionalidade',
                    'descricao' => 'Desenvolvimento da funcionalidade de exportação PDF',
                    'pontuacao' => 5,
                    'data_inicio' => now()->startOfWeek(),
                    'data_fim' => now(),
                ]);
                
                // Tarefa da semana anterior
                Tarefa::create([
                    'dev_id' => $dev->id,
                    'numero_semana' => $semanaAtual - 1,
                    'nome_tarefa' => 'Corrigir bugs',
                    'descricao' => 'Correção de bugs no módulo de relatórios',
                    'pontuacao' => rand(2, 5),
                    'data_inicio' => now()->subWeek()->startOfWeek(),
                    'data_fim' => now()->subWeek()->endOfWeek(),
                ]);
                
                // Tarefa de duas semanas atrás
                Tarefa::create([
                    'dev_id' => $dev->id,
                    'numero_semana' => $semanaAtual - 2,
                    'nome_tarefa' => 'Reuniões de planejamento',
                    'descricao' => 'Participação em reuniões de planejamento',
                    'pontuacao' => rand(0, 3),
                    'data_inicio' => now()->subWeeks(2)->startOfWeek(),
                    'data_fim' => now()->subWeeks(2)->endOfWeek(),
                ]);
            }
        }
    }
}