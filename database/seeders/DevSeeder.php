<?php

namespace Database\Seeders;

use App\Models\Dev;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar alguns desenvolvedores de exemplo
        Dev::create([
            'nome' => 'João Silva',
            'cargo' => 'Desenvolvedor Backend',
            'email' => 'joao@exemplo.com',
            'data_inicio' => now()->subMonths(6),
            'faixa' => 'verde',
        ]);

        Dev::create([
            'nome' => 'Maria Souza',
            'cargo' => 'Desenvolvedora Frontend',
            'email' => 'maria@exemplo.com',
            'data_inicio' => now()->subMonths(12),
            'faixa' => 'amarela',
        ]);

        Dev::create([
            'nome' => 'Carlos Oliveira',
            'cargo' => 'Desenvolvedor Full-Stack',
            'email' => 'carlos@exemplo.com',
            'data_inicio' => now()->subMonths(24),
            'faixa' => 'preta',
        ]);
    }
}