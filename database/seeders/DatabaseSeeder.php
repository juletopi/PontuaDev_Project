<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Executar os seeders específicos do projeto
        $this->call([
            DevSeeder::class,
            TarefaSeeder::class,
        ]);
    }
}
