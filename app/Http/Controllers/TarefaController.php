<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Models\Dev;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TarefaController extends Controller
{
public function index(Request $request)
    {
        $query = Tarefa::with('dev');

        // Filtros simples
        $tarefas = collect();
        if ($request->filled('semana_inicio') || $request->filled('semana_fim')) {
            $querySemanas = Tarefa::with('dev');
            if ($request->filled('semana_inicio') && $request->filled('semana_fim')) {
                $inicio = min($request->semana_inicio, $request->semana_fim);
                $fim = max($request->semana_inicio, $request->semana_fim);
                $querySemanas->whereBetween('numero_semana', [$inicio, $fim]);
            } elseif ($request->filled('semana_inicio')) {
                $querySemanas->where('numero_semana', $request->semana_inicio);
            } elseif ($request->filled('semana_fim')) {
                $querySemanas->where('numero_semana', $request->semana_fim);
            }
            $tarefas = $querySemanas->orderByDesc('numero_semana')->get();
            
            // Ordena tarefas por faixa do dev atribuído e dev_id
            $ordemFaixas = array_flip(Dev::$faixas);
            $tarefas = $tarefas->sortBy(function($tarefa) use ($ordemFaixas) {
                if (!$tarefa->dev || !$tarefa->dev->faixa) return [-1, $tarefa->dev_id];
                return [$ordemFaixas[$tarefa->dev->faixa], $tarefa->dev_id];
            })->values();
        } elseif ($request->filled('data_inicio') || $request->filled('data_fim')) {
            $queryDatas = Tarefa::with('dev');
            if ($request->filled('data_inicio') && $request->filled('data_fim')) {
                $queryDatas->whereBetween('data_fim', [$request->data_inicio, $request->data_fim]);
            } elseif ($request->filled('data_inicio')) {
                $queryDatas->where('data_fim', '>=', $request->data_inicio);
            } elseif ($request->filled('data_fim')) {
                $queryDatas->where('data_fim', '<=', $request->data_fim);
            }
            $tarefas = $queryDatas->orderByDesc('numero_semana')->get();
            
            $ordemFaixas = array_flip(Dev::$faixas);
            $tarefas = $tarefas->sortBy(function($tarefa) use ($ordemFaixas) {
                if (!$tarefa->dev || !$tarefa->dev->faixa) return [-1, $tarefa->dev_id];
                return [$ordemFaixas[$tarefa->dev->faixa], $tarefa->dev_id];
            })->values();
        } else {
            // Exibe só a última tarefa semanal de cada dev
            $tarefas = Tarefa::select('dev_id', 'numero_semana', 'nome_tarefa', 'descricao', 'pontuacao', 'data_inicio', 'data_fim', 'id')
                ->with('dev')
                ->orderByDesc('numero_semana')
                ->get()
                ->groupBy('dev_id')
                ->map(function($group) { return $group->first(); })
                ->values();
                
            $ordemFaixas = array_flip(Dev::$faixas);
            $tarefas = $tarefas->sortBy(function($tarefa) use ($ordemFaixas) {
                if (!$tarefa->dev || !$tarefa->dev->faixa) return -1;
                return $ordemFaixas[$tarefa->dev->faixa];
            })->values();
        }
        
        // Filtros avançados
        if ($request->filled('status')) {
            $tarefas = $tarefas->filter(function($tarefa) use ($request) {
                return in_array($tarefa->pontuacao, (array) $request->status);
            });
        }
        if ($request->filled('dev')) {
            $tarefas = $tarefas->filter(function($tarefa) use ($request) {
                return in_array($tarefa->dev_id, (array) $request->dev);
            });
        }
        
        // Devs filtrados (únicos baseados nas tarefas filtradas) - ordenados por faixa
        $devIds = $tarefas->pluck('dev_id')->unique();
        
        $ordemFaixas = array_flip(Dev::$faixas);
        $devsFiltrados = Dev::whereIn('id', $devIds)->get()->sortBy(function($dev) use ($ordemFaixas) {
            return $dev->faixa ? $ordemFaixas[$dev->faixa] : -1;
        });

        // Calcular métricas por dev
        foreach ($devsFiltrados as $dev) {
            $devTarefas = $tarefas->where('dev_id', $dev->id);
            $dev->media = $devTarefas->avg('pontuacao') ?? 0;
            $dev->total = $devTarefas->sum('pontuacao') ?? 0;
            $numTarefas = $devTarefas->count();
            $dev->porcentagem = $numTarefas > 0 ? round(($dev->total / ($numTarefas * 5)) * 100) : 0;
        }

        return view('tarefas.index', compact('tarefas', 'devsFiltrados'));
    }

    public function create()
    {
        $devs = Dev::all();
        $opcoesPontuacao = [
            0 => 'Zerou',
            2 => 'Saiu algo',
            3 => 'Quase',
            5 => 'Deu bom',
            8 => 'Extra',
        ];
        return view('tarefas.create', compact('devs', 'opcoesPontuacao'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dev_id' => 'required|exists:devs,id',
            'numero_semana' => 'required|integer',
            'nome_tarefa' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'pontuacao' => 'required|in:0,2,3,5,8',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $tarefa = Tarefa::create($validated);

        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function show($id)
    {
        $tarefa = Tarefa::with('dev')->findOrFail($id);
        return view('tarefas.show', compact('tarefa'));
    }

    public function edit($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $devs = Dev::all(); 
        $opcoesPontuacao = [
            0 => 'Zerou',
            2 => 'Saiu algo',
            3 => 'Quase',
            5 => 'Deu bom',
            8 => 'Extra',
        ];
        return view('tarefas.edit', compact('tarefa', 'devs', 'opcoesPontuacao'));
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);

        $validated = $request->validate([
            'dev_id' => 'required|exists:devs,id',
            'numero_semana' => 'required|integer',
            'nome_tarefa' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'pontuacao' => 'required|in:0,2,3,5,8',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $tarefa->update($validated);

        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();
        return redirect()->route('tarefas.index')->with('success', 'Tarefa removida com sucesso!');
    }

    public function exportPdf(Request $request)
    {
        // Repete a lógica de filtro do index
        $query = Tarefa::with('dev');
        $tarefas = collect();
        if ($request->filled('semana_inicio') || $request->filled('semana_fim')) {
            $querySemanas = Tarefa::with('dev');
            if ($request->filled('semana_inicio') && $request->filled('semana_fim')) {
                $inicio = min($request->semana_inicio, $request->semana_fim);
                $fim = max($request->semana_inicio, $request->semana_fim);
                $querySemanas->whereBetween('numero_semana', [$inicio, $fim]);
            } elseif ($request->filled('semana_inicio')) {
                $querySemanas->where('numero_semana', $request->semana_inicio);
            } elseif ($request->filled('semana_fim')) {
                $querySemanas->where('numero_semana', $request->semana_fim);
            }
            $tarefas = $querySemanas->orderByDesc('numero_semana')->get();
            
            $ordemFaixas = array_flip(Dev::$faixas);
            $tarefas = $tarefas->sortBy(function($tarefa) use ($ordemFaixas) {
                if (!$tarefa->dev || !$tarefa->dev->faixa) return [-1, $tarefa->dev_id];
                return [$ordemFaixas[$tarefa->dev->faixa], $tarefa->dev_id];
            })->values();
        } elseif ($request->filled('data_inicio') || $request->filled('data_fim')) {
            $queryDatas = Tarefa::with('dev');
            if ($request->filled('data_inicio') && $request->filled('data_fim')) {
                $queryDatas->whereBetween('data_fim', [$request->data_inicio, $request->data_fim]);
            } elseif ($request->filled('data_inicio')) {
                $queryDatas->where('data_fim', '>=', $request->data_inicio);
            } elseif ($request->filled('data_fim')) {
                $queryDatas->where('data_fim', '<=', $request->data_fim);
            }
            $tarefas = $queryDatas->orderByDesc('numero_semana')->get();
            
            $ordemFaixas = array_flip(Dev::$faixas);
            $tarefas = $tarefas->sortBy(function($tarefa) use ($ordemFaixas) {
                if (!$tarefa->dev || !$tarefa->dev->faixa) return [-1, $tarefa->dev_id];
                return [$ordemFaixas[$tarefa->dev->faixa], $tarefa->dev_id];
            })->values();
        } else {
            $tarefas = Tarefa::select('dev_id', 'numero_semana', 'nome_tarefa', 'descricao', 'pontuacao', 'data_inicio', 'data_fim', 'id')
                ->with('dev')
                ->orderByDesc('numero_semana')
                ->get()
                ->groupBy('dev_id')
                ->map(function($group) { return $group->first(); })
                ->values();

            $ordemFaixas = array_flip(Dev::$faixas);
            $tarefas = $tarefas->sortBy(function($tarefa) use ($ordemFaixas) {
                if (!$tarefa->dev || !$tarefa->dev->faixa) return [-1, $tarefa->dev_id];
                return [$ordemFaixas[$tarefa->dev->faixa], $tarefa->dev_id];
            })->values();
        }
        
        if ($request->filled('status')) {
            $tarefas = $tarefas->filter(function($tarefa) use ($request) {
                return in_array($tarefa->pontuacao, (array) $request->status);
            });
        }
        if ($request->filled('dev')) {
            $tarefas = $tarefas->filter(function($tarefa) use ($request) {
                return in_array($tarefa->dev_id, (array) $request->dev);
            });
        }
        
        $devIds = $tarefas->pluck('dev_id')->unique();

        $ordemFaixas = array_flip(Dev::$faixas);
        $devsFiltrados = Dev::whereIn('id', $devIds)->get()->sortBy(function($dev) use ($ordemFaixas) {
            return $dev->faixa ? $ordemFaixas[$dev->faixa] : -1;
        });
        
        foreach ($devsFiltrados as $dev) {
            $devTarefas = $tarefas->where('dev_id', $dev->id);
            $dev->media = $devTarefas->avg('pontuacao') ?? 0;
            $dev->total = $devTarefas->sum('pontuacao') ?? 0;
            $numTarefas = $devTarefas->count();
            $dev->porcentagem = $numTarefas > 0 ? round(($dev->total / ($numTarefas * 5)) * 100) : 0;
        }
        
        // Reordenar desenvolvedores por pontuação total (decrescente)
        $devsFiltrados = $devsFiltrados->sortByDesc('total')->values();
        
        $statusMap = [0=>'Zerou',2=>'Saiu algo',3=>'Quase',5=>'Deu bom',8=>'Extra'];
        $filename = 'listaTarefas_' . date('Ymd') . '_' . uniqid() . '.pdf';
        $pdf = Pdf::loadView('tarefas.pdf', compact('tarefas', 'devsFiltrados', 'statusMap'));
        return $pdf->download($filename);
    }
}
