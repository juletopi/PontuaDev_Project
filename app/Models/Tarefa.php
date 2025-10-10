<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'dev_id',
        'numero_semana',
        'nome_tarefa',
        'descricao',
        'pontuacao',
        'data_inicio',
        'data_fim',
    ];
    
    public function dev()
    {
        return $this->belongsTo(Dev::class);
    }
}
