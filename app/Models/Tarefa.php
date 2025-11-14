<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'dev_id',
        'numero_semana',
        'nome_tarefa',
        'anotacao',
        'itens',
        'extras',
        'pontuacao',
        'data_inicio',
        'data_fim',
    ];
    
    protected $casts = [
        'itens' => 'array',
        'extras' => 'array',
        'data_inicio' => 'date',
        'data_fim' => 'date',
    ];
    
    public function dev()
    {
        return $this->belongsTo(Dev::class);
    }
}
