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
        'branca' => '#ddddddff',
        'amarela' => '#ebdb4dff',
        'vermelha' => '#e53935',
        'laranja' => '#ee7b1dff',
        'verde' => '#43a047ff',
        'roxa' => '#873cb9ff',
        'marrom' => '#835323ff',
        'preta' => '#1a1a1aff',
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
