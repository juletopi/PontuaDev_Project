<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dev extends Model
{
    protected $fillable = [
        'nome',
        'cargo',
        'email',
        'data_inicio',
        'avatar',
        'faixa',
    ];

    public static $faixas = [
        'branca',
        'amarela',
        'vermelha',
        'laranja',
        'verde',
        'roxa',
        'marrom',
        'preta',
    ];

    public static $faixaCores = [
        'branca' => '#dddddd',
        'amarela' => '#dbcb53',
        'vermelha' => '#c0463f',
        'laranja' => '#e07c3e',
        'verde' => '#539b51',
        'roxa' => '#7a5a8f',
        'marrom' => '#7a5a48',
        'preta' => '#37393d',
    ];

    public function getTempoExperienciaAttribute()
    {
        if (!$this->data_inicio) return null;
        $inicio = \Carbon\Carbon::parse($this->data_inicio);
        $agora = \Carbon\Carbon::now();
        $diff = $inicio->diff($agora);
        $anos = $diff->y;
        $meses = $diff->m;
        return $anos . ' ano(s)' . ($meses > 0 ? ' e ' . $meses . ' mês(es)' : '');
    }
    
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class);
    }
}
