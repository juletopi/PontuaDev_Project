<?php

namespace App\Http\Controllers;

use App\Models\Dev;
use Illuminate\Http\Request;

class DevController extends Controller
{
    public function index()
    {
        // Ordena devs por faixa
        $ordemFaixas = array_flip(Dev::$faixas);
        $devs = Dev::all()->sortBy(function($dev) use ($ordemFaixas) {
            return $dev->faixa ? $ordemFaixas[$dev->faixa] : -1;
        });
        
        // Calc média geral e porcentagem de aproveitamento
        foreach ($devs as $dev) {
            $tarefas = $dev->tarefas ?? collect();
            $dev->media_geral = $tarefas->avg('pontuacao') ?? 0;
            $dev->total_pontos = $tarefas->sum('pontuacao') ?? 0;
            $numTarefas = $tarefas->count();
            $dev->porcentagem_aproveitamento = $numTarefas > 0 ? round(($dev->total_pontos / ($numTarefas * 5)) * 100) : 0;
            $dev->tarefas_paginadas = $dev->tarefas()->orderByDesc('numero_semana')->paginate(5, ['*'], 'dev_'.$dev->id.'_page');
        }
        return view('devs.index', compact('devs'));
    }

    public function create()
    {
        return view('devs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:devs,nome',
            'cargo' => 'required|string|max:255',
            'email' => 'nullable|email|unique:devs,email',
            'data_inicio' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'faixa' => 'nullable|in:branca,amarela,vermelha,laranja,verde,roxa,marrom,preta',
        ]);

        $dev = Dev::create(array_merge($validated, ['avatar' => $path ?? null]));

        // Upload avatar
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'avatar_' . \Str::slug($request->nome) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $filename, 'public');
            $dev->avatar = $path;
            $dev->save();
        }

        return redirect()->route('devs.index')->with('success', 'Dev criado com sucesso!');
    }

    public function show($id)
    {
        $dev = Dev::findOrFail($id);
        return view('devs.show', compact('dev'));
    }

    public function edit($id)
    {
        $dev = Dev::findOrFail($id);
        return view('devs.edit', compact('dev'));
    }

    public function update(Request $request, $id)
    {
        $dev = Dev::findOrFail($id);
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:devs,nome,' . $id,
            'cargo' => 'required|string|max:255',
            'email' => 'nullable|email|unique:devs,email,' . $id,
            'data_inicio' => 'nullable|date',
            'faixa' => 'nullable|in:branca,amarela,vermelha,laranja,verde,roxa,marrom,preta|max:255',
        ]);

        $dev->update($validated);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $dev->avatar = $path;
            $dev->save();
        }

        return redirect()->route('devs.index')->with('success', 'Dev atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $dev = Dev::findOrFail($id);
        $dev->delete();
        return redirect()->route('devs.index')->with('success', 'Dev removido com sucesso!');
    }

    public function tarefasAjax($id, Request $request)
    {
        $dev = Dev::findOrFail($id);
        $tarefas = $dev->tarefas()->orderByDesc('numero_semana')->paginate(5);
        $statusMap = [0=>'Zerou',2=>'Saiu algo',3=>'Quase',5=>'Deu bom',8=>'Extra'];
        return view('devs._tarefas', compact('tarefas', 'statusMap', 'dev'))->render();
    }
}
