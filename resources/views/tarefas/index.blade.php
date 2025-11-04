@php use App\Models\Tarefa; @endphp
@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-fixed-top" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- Breadcrumb nav -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('devs.index') }}">Lista de devs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Painel de tarefas</li>
        </ol>
    </nav>

    <!-- Btn add tarefa -->
    <div class="row justify-content-center mb-4">
        <div class="col-12 d-flex justify-content-center">
            <a href="{{ route('tarefas.create') }}" class="btn btn-outline-primary mb-3 btn-adicionar-tarefa">
                <i class="bi bi-plus-circle"></i> Adicionar tarefa
            </a>
        </div>
    </div>

    <!-- Card lista tarefas -->
    <div class="card card-dev shadow-lg p-4 mb-4">
        <form method="GET" id="filtro-form">
            @php
                $semanas = Tarefa::select('numero_semana')->distinct()->pluck('numero_semana')->sortDesc();
            @endphp
            <!-- Filtros simples -->
            <div class="row">
                <div class="col-md-4 d-flex align-items-end" style="gap:1.5rem;">
                    <div style="width:100%;">
                        <label>Semana</label>
                        <div class="d-flex align-items-center" style="gap:0.5rem;">
                            <select name="semana_inicio" id="semana_inicio" class="form-control" style="border-radius: 50rem; min-width: 140px; max-width: 180px;">
                                <option value="">Mais recente</option>
                                @foreach($semanas as $semana)
                                    <option value="{{ $semana }}" {{ request('semana_inicio') == $semana ? 'selected' : '' }}>[{{ $semana }}]</option>
                                @endforeach
                            </select>
                            <span class="text-muted mx-2" style="font-size:1rem;">até</span>
                            <select name="semana_fim" id="semana_fim" class="form-control" style="border-radius: 50rem; min-width: 140px; max-width: 180px;">
                                <option value="">Mais recente</option>
                                @foreach($semanas as $semana)
                                    <option value="{{ $semana }}" {{ request('semana_fim') == $semana ? 'selected' : '' }}>[{{ $semana }}]</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end" id="filtro-data-col" style="gap:1.5rem; padding-left:2rem;">
                    <div style="width:100%;">
                        <label>Data</label>
                        <div class="d-flex align-items-center" style="gap:0.5rem;">
                            <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{ request('data_inicio') }}" style="max-width:180px; border-radius:50rem;">
                            <span class="text-muted mx-2" style="font-size:1rem;">até</span>
                            <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ request('data_fim') }}" style="max-width:180px; border-radius:50rem;">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex flex-column align-items-start" style="gap:0.5rem; padding-left:5rem;">
                    <label class="mb-1" style="font-size:1.1rem; font-weight:500;">
                        Filtros avançados
                    </label>
                    <div class="custom-control custom-switch" style="margin-top:0.2rem;">
                        <input type="checkbox" class="custom-control-input" id="switch-filtros-avancados" style="">
                        <label class="custom-control-label" for="switch-filtros-avancados"></label>
                    </div>
                </div>
            </div>

            <!-- Filtros avançados -->
            <div class="collapse filtros-avancados-box" id="collapseFiltrosAvancados">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Status</label>
                        @php
                            $statusOpcoes = [0=>'Zerou',2=>'Saiu algo',3=>'Quase',5=>'Deu bom',8=>'Extra'];
                            $statusSelecionados = (array) request('status', []);
                        @endphp
                        <div class="d-flex flex-wrap" style="gap:0.7rem;">
                            @foreach($statusOpcoes as $valor => $label)
                                <label class="filtro-badge @if(in_array($valor, $statusSelecionados)) selected @endif" for="status_{{ $valor }}">
                                    <input type="checkbox" name="status[]" value="{{ $valor }}" id="status_{{ $valor }}" {{ in_array($valor, $statusSelecionados) ? 'checked' : '' }}>
                                    <span class="badge
                                        @if($valor == 0) badge-status-zerou
                                        @elseif($valor == 2) badge-status-saiualgo
                                        @elseif($valor == 3) badge-status-quase
                                        @elseif($valor == 5) badge-status-deubom
                                        @elseif($valor == 8) badge-status-extra
                                        @else badge-secondary @endif"
                                        style="font-size:1rem;">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Dev</label>
                        @php
                            $devsTodos = \App\Models\Dev::orderBy('id')->get();
                            $devSelecionados = (array) request('dev', []);
                        @endphp
                        <div class="d-flex flex-wrap" style="gap:1rem;">
                            @foreach($devsTodos as $dev)
                                <label class="filtro-dev @if(in_array($dev->id, $devSelecionados)) selected @endif" for="dev_{{ $dev->id }}">
                                    <input type="checkbox" name="dev[]" value="{{ $dev->id }}" id="dev_{{ $dev->id }}" {{ in_array($dev->id, $devSelecionados) ? 'checked' : '' }}>
                                    @if($dev->avatar)
                                        <img src="{{ asset('storage/' . $dev->avatar) }}" class="rounded-circle" style="width:30px; height:30px; object-fit:cover;">
                                    @else
                                        <span class="rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:#f8f9fa; color:#ccc; font-size:1.7rem;">
                                            <i class="bi bi-person-circle"></i>
                                        </span>
                                    @endif
                                    <span>{{ $dev->nome }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ações do form -->
            <div class="row">
                <div class="col-md-6 d-flex justify-content-start align-items-center" style="gap:1rem; margin-top:1.6rem;">
                    <button type="submit" class="btn btn-primary d-flex align-items-center" style="height:40px;">
                        <i class="bi bi-funnel" style="font-size:1.2rem; margin-right:0.5rem;"></i> Filtrar
                    </button>
                    <a href="{{ route('tarefas.index') }}" class="btn btn-outline-secondary d-flex align-items-center" style="height:40px;">
                        <i class="bi bi-x-circle" style="font-size:1.2rem; margin-right:0.5rem;"></i> Limpar filtros
                    </a>
                    <button type="button" class="btn btn-secondary d-flex align-items-center" id="btn-export-pdf" style="height:40px; background:#6c757d; color:#fff; border:none;">
                        <i class="bi bi-download" style="font-size:1.2rem; margin-right:0.5rem;"></i> Exportar PDF
                    </button>
                </div>
            </div>
        </form>

        <hr style="margin-top:2rem;">

        <!-- Tabela -->
        <div id="tarefas-tabela" class="table-responsive" style="margin-top:1rem;">
            <table class="table table-borderless table-zebra">
                <thead>
                    <tr>
                        <th>Semana</th>
                        <th>Tarefa</th>
                        <th>Responsável</th>
                        <th>Status</th>
                        <th>Pts</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statusMap = [0=>'Zerou',2=>'Saiu algo',3=>'Quase',5=>'Deu bom',8=>'Extra'];
                    @endphp
                    @foreach($tarefas as $tarefa)
                        <tr>
                            <td>[{{ $tarefa->numero_semana }}]</td>
                            <td>{{ $tarefa->nome_tarefa }}</td>
                            <td>
                                @if($tarefa->dev)
                                    <div class="d-flex align-items-center">
                                        @if($tarefa->dev && $tarefa->dev->avatar)
                                            <img src="{{ asset('storage/' . $tarefa->dev->avatar) }}" alt="avatar" class="rounded-circle mr-2" style="width: 30px; height: 30px; object-fit:cover;">
                                        @else
                                            <span class="rounded-circle mr-2 d-flex align-items-center justify-content-center" style="width:30px; height:30px; background:#f8f9fa; color:#bbb; font-size:1.5rem;">
                                                <i class="bi bi-person-circle" style="font-size:2rem;"></i>
                                            </span>
                                        @endif
                                        {{ $tarefa->dev->nome }}
                                    </div>
                                @else
                                    -----
                                @endif
                            </td>
                            <td>
                                <span class="badge
                                    @if(is_null($tarefa->pontuacao)) badge-status-doing
                                    @elseif($tarefa->pontuacao == 0) badge-status-zerou
                                    @elseif($tarefa->pontuacao == 2) badge-status-saiualgo
                                    @elseif($tarefa->pontuacao == 3) badge-status-quase
                                    @elseif($tarefa->pontuacao == 5) badge-status-deubom
                                    @elseif($tarefa->pontuacao == 8) badge-status-extra
                                    @else badge-secondary @endif"
                                    style="font-size:1rem;">
                                    {{ is_null($tarefa->pontuacao) ? 'DOING' : ($statusMap[$tarefa->pontuacao] ?? '--') }}
                                </span>
                            </td>
                            <td style="text-align:center;">{{ $tarefa->pontuacao ?? '--' }}</td>
                            <td class="dev-actions d-flex align-items-center" style="gap:0.5rem;">
                                <button type="button" class="btn-view btn-sm" data-tarefa-id="{{ $tarefa->id }}"><i class="bi bi-eye"></i></button>
                                <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="btn-edit btn-sm"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn-delete btn-sm" data-toggle="modal" data-target="#deleteModal{{ $tarefa->id }}"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr style="margin-top:2rem; margin-bottom:2rem;">

        <!-- Métricas -->
        <div class="mt-4">
            <span class="font-weight-bold" style="font-size:1.4rem;">
                Desenvolvedor(es) <span style="font-size:2rem; vertical-align:middle; margin-left:0.3rem;">{{ $devsFiltrados->count() }}</span>
            </span>
            <div class="d-flex flex-wrap pontuacao-list-tarefas mt-2" style="gap: 1.2rem;">
                @php
                    $devsFiltradosOrdenados = $devsFiltrados->sortByDesc('total')->values();
                @endphp
                @foreach($devsFiltradosOrdenados as $index => $dev)
                    @php
                        $posicao = $index + 1;
                        $corBookmark = '';
                        $tamanhoBookmark = '';
                        
                        if ($posicao === 1) {
                            $corBookmark = '#FFD700';
                            $tamanhoBookmark = '42px';
                        } elseif ($posicao === 2) {
                            $corBookmark = '#C0C0C0';
                            $tamanhoBookmark = '38px';
                        } elseif ($posicao === 3) {
                            $corBookmark = '#CD7F32';
                            $tamanhoBookmark = '38px';
                        } else {
                            $corBookmark = '#6c757d';
                            $tamanhoBookmark = '30px';
                        }
                    @endphp
                    <div class="d-flex flex-column align-items-start position-relative" 
                         style="gap: 0.7rem; border-radius: 0 1.2rem 1.2rem 0.3rem; padding: 1.1rem 2.2rem 1.1rem 2rem; min-width: 320px; margin-left:1rem;
                                background: {{ $posicao === 1 ? '#fffae6' : ($posicao === 2 ? '#f8f9fa' : ($posicao === 3 ? '#fff7f2' : '#f7f9fb')) }}; 
                                border-left: 5px solid {{ $corBookmark }};">
                        
                        <!-- Indicador de posição -->
                        <div class="badge" 
                             style="position: absolute; top: -10px; z-index: 10;
                                    left: -{{ $posicao === 1 ? '28px' : ($posicao <= 3 ? '26px' : '23px') }};">
                            <div class="badge-content" 
                                 style="width: {{ $tamanhoBookmark }}; 
                                        height: {{ $tamanhoBookmark }}; 
                                        background-color: {{ $corBookmark }}; 
                                        clip-path: polygon(0% 0%, 100% 0%, 100% 75%, 50% 100%, 0% 75%); 
                                        display: flex; justify-content: center; align-items: center; 
                                        padding-bottom: {{ $posicao <= 3 ? '8px' : '5px' }};">
                                <span style="color: #fff; 
                                           font-weight: bold; 
                                           font-size: {{ $posicao <= 3 ? '1.3rem' : '1rem' }};">
                                    {{ $posicao }}
                                </span>
                            </div>
                        </div>
                        @php
                            $borda = $dev->faixa && isset(\App\Models\Dev::$faixaCores[$dev->faixa]) ? \App\Models\Dev::$faixaCores[$dev->faixa] : '#ccc';
                        @endphp
                        <div class="d-flex align-items-center" style="gap: 4rem; width:100%;">
                            @if($dev->avatar)
                                <img src="{{ asset('storage/' . $dev->avatar) }}" alt="avatar" class="avatar-metrica" style="border: 4px solid {{ $borda }}; background: #f8f9fa; color:#ccc; width:65px; height:65px; object-fit:cover;">
                            @else
                                <span class="avatar-metrica d-flex align-items-center justify-content-center" style="color:#ccc; background:#f8f9fa; width:65px; height:65px; border-radius:50%;">
                                    <i class="bi bi-person-circle" style="font-size:4rem;"></i>
                                </span>
                            @endif
                            <div>
                                <div class="pontuacao-topico">Média selecionada <i class="bi bi-question-circle" data-toggle="tooltip" title="Média de pontos das tarefas selecionadas"></i></div>
                                <div class="pontuacao-valor">{{ number_format($dev->media, 1) }} pts</div>
                            </div>
                            <div>
                                <div class="pontuacao-topico">Total de pontos <i class="bi bi-question-circle" data-toggle="tooltip" title="Soma total de pontos das tarefas selecionadas"></i></div>
                                <div class="pontuacao-valor">{{ $dev->total }} pts</div>
                            </div>
                            <div>
                                <div class="pontuacao-topico">Porcentagem de aproveitamento <i class="bi bi-question-circle" data-toggle="tooltip" title="Percentual de aproveitamento baseado no máximo possível de pontos das tarefas selecionadas"></i></div>
                                <div class="pontuacao-valor">{{ $dev->porcentagem }}%</div>
                            </div>
                        </div>

                        <hr style="width:100%; border-top:1px solid #ddd; margin-top:1rem; margin-bottom:0.3rem;">

                        <div class="d-flex w-100 mt-3" style="gap:2.2rem; margin-left:6rem;">
                            @php
                                $statusContagem = [0=>'Zerou',2=>'Saiu algo',3=>'Quase',5=>'Deu bom',8=>'Extra'];
                                $statusCores = [
                                    0 => '#bcbcbc',
                                    2 => '#f0ce67',
                                    3 => '#1979ce',
                                    5 => '#218838',
                                    8 => '#a44fb0',
                                ];
                                $devTarefas = $tarefas->where('dev_id', $dev->id);
                                $totalTarefas = $devTarefas->count();
                            @endphp
                            @foreach($statusContagem as $valor => $label)
                                @php
                                    // Contar apenas tarefas avaliadas com pontuação exatamente igual (strict) ao valor
                                    $qtd = $devTarefas->filter(function($t) use ($valor) {
                                        return isset($t->pontuacao) && (int) $t->pontuacao === (int) $valor;
                                    })->count();
                                @endphp
                                <span style="display:flex; align-items:center; font-size:1.13rem; gap:0.45rem;">
                                    <span style="font-size:1.05rem;">{{ $qtd }}</span>
                                    <span style="width:13px; height:13px; border-radius:50%; background:{{ $statusCores[$valor] }}; display:inline-block;"></span>
                                    <span style="color:#888; font-size:1.05rem;">{{ $label }}</span>
                                </span>
                            @endforeach
                            <span style="display:flex; align-items:center; font-size:1.13rem; gap:0.45rem; margin-left:1rem; border-left:1px solid #ddd; padding-left:1rem;">
                                <span style="font-size:1.05rem; font-weight:600;">{{ $totalTarefas }}</span>
                                <span style="color:#444; font-size:1.05rem; font-weight:500;">Total</span>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal excluir tarefa -->
    @foreach($tarefas as $tarefa)
        <div class="modal fade" id="deleteModal{{ $tarefa->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-delete">
                    <div class="modal-icon">
                        <i class="bi bi-trash" aria-hidden="true"></i>
                    </div>
                    <div class="modal-body">
                        <h5 class="modal-title-delete">Excluir tarefa</h5>
                        <p class="modal-desc">Essa ação é irreversível e irá afetar a pontuação do dev atribuído a ela.</p>
                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" data-dismiss="modal">Cancelar</button>
                            <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-confirm">Sim, excluir tarefa</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal visualizar tarefa -->
    @foreach($tarefas as $tarefa)
        <div class="modal fade custom-modal-tarefa" id="viewModal{{ $tarefa->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:900px;">
                <div class="modal-content" style="border-radius:1.2rem;">
                    <div class="modal-header" style="border-bottom:1px solid #eee;">
                        <h5 class="modal-title" style="font-size:1.45rem; font-weight:600; margin-left:1.8rem; margin-top:0.3rem;">
                            [{{ $tarefa->numero_semana }}] {{ $tarefa->nome_tarefa }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:2.7rem 2.7rem 2.1rem 2.7rem;">
                        <div class="row">
                            <div class="col-md-7 pr-4">
                                <label style="font-weight:700; font-size:1.13rem;">Descrição</label>
                                <div style="background:#f7f9fb; border-radius:0.7rem; min-height:140px; padding:1.3rem 1.3rem; font-size:1.13rem; color:#444; margin-top:0.5rem;">
                                    {{ $tarefa->descricao ?? 'Nenhuma descrição' }}
                                </div>
                            </div>
                            <div class="col-md-5 d-flex flex-column" style="gap:1.5rem;">
                                <div>
                                    <label style="font-weight:700; font-size:1.13rem;">Dev responsável</label>
                                    @if($tarefa->dev)
                                        @php
                                            $avatar = $tarefa->dev->avatar
                                                ? asset('storage/' . $tarefa->dev->avatar)
                                                : 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg';
                                            $borda = $tarefa->dev->faixa && isset(\App\Models\Dev::$faixaCores[$tarefa->dev->faixa])
                                                ? \App\Models\Dev::$faixaCores[$tarefa->dev->faixa]
                                                : '#ccc';
                                        @endphp
                                        <div class="d-flex align-items-center mt-2" style="gap:1.2rem;">
                                            @if($tarefa->dev->avatar)
                                                <img src="{{ $avatar }}"
                                                    alt="avatarDev"
                                                    class="rounded-circle mr-4"
                                                    style="border: 4px solid {{ $borda }}; background: #f8f9fa; width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <span class="rounded-circle mr-4 d-flex align-items-center justify-content-center" style="background: #f8f9fa; color:#bbb; width: 60px; height: 60px;">
                                                    <i class="bi bi-person-circle" style="font-size:4.4rem;"></i>
                                                </span>
                                            @endif
                                            <div style="margin-left:-1.2rem;">
                                                <div style="font-size:1.18rem; color:#444; font-weight:500;">{{ $tarefa->dev->nome }}</div>
                                                <div style="font-size:1.07rem; color:#888;">{{ $tarefa->dev->cargo }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-2" style="color:#888;">-</div>
                                    @endif
                                </div>
                                <div>
                                    <label style="font-weight:700; font-size:1.13rem;">Pontuação</label>
                                    <div class="mt-2">
                                        <span class="badge
                                            @if(is_null($tarefa->pontuacao)) badge-status-doing
                                            @elseif($tarefa->pontuacao == 0) badge-status-zerou
                                            @elseif($tarefa->pontuacao == 2) badge-status-saiualgo
                                            @elseif($tarefa->pontuacao == 3) badge-status-quase
                                            @elseif($tarefa->pontuacao == 5) badge-status-deubom
                                            @elseif($tarefa->pontuacao == 8) badge-status-extra
                                            @else badge-secondary @endif"
                                            style="font-size:1rem; padding:0.5rem 1rem;">
                                            {{ is_null($tarefa->pontuacao) ? 'DOING' : ($statusMap[$tarefa->pontuacao] ?? '--') }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label style="font-weight:700; font-size:1.13rem;">Período</label>
                                    <div class="mt-2" style="font-size:1.13rem; color:#444;">
                                        {{ $tarefa->data_inicio ? \Carbon\Carbon::parse($tarefa->data_inicio)->format('d/m/Y') : '-- / -- / ----' }}
                                        <span style="color:#888; margin:0 0.5rem;">até</span>
                                        {{ $tarefa->data_fim ? \Carbon\Carbon::parse($tarefa->data_fim)->format('d/m/Y') : '-- / -- / ----' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
<script>
$(function() {
    // Collapse dos filtros avançados
    $('#switch-filtros-avancados').on('change', function(){
        $('#collapseFiltrosAvancados').collapse($(this).is(':checked') ? 'show' : 'hide');
    });
    // Exclusividade dos filtros simples + efeito visual
    function updateFiltroSimplesVisual() {
        var semanaAtivo = $('#semana_inicio').val() || $('#semana_fim').val();
        var dataAtivo = $('#data_inicio').val() || $('#data_fim').val();
        if(semanaAtivo) {
            $('#filtro-data-col').addClass('filtro-desativado');
            $('#semana_inicio, #semana_fim').closest('div').removeClass('filtro-desativado');
        } else if(dataAtivo) {
            $('#semana_inicio, #semana_fim').closest('div').addClass('filtro-desativado');
            $('#filtro-data-col').removeClass('filtro-desativado');
        } else {
            $('#semana_inicio, #semana_fim').closest('div').removeClass('filtro-desativado');
            $('#filtro-data-col').removeClass('filtro-desativado');
        }
    }
    $('#semana_inicio, #semana_fim, #data_inicio, #data_fim').on('change input', updateFiltroSimplesVisual);
    updateFiltroSimplesVisual();
    // Exclusividade dos filtros simples
    $('#semana_inicio, #semana_fim').on('change', function(){
        $('#data_inicio, #data_fim').val('');
    });
    $('#data_inicio, #data_fim').on('change', function(){
        $('#semana_inicio, #semana_fim').val('');
    });
    // Filtros avançados efeito selecionado
    $('.filtro-badge input[type="checkbox"]').on('change', function(){
        var $label = $(this).closest('.filtro-badge');
        if(this.checked) {
            $label.addClass('selected');
        } else {
            $label.removeClass('selected');
        }
    });
    $('.filtro-dev input[type="checkbox"]').on('change', function(){
        var $label = $(this).closest('.filtro-dev');
        if(this.checked) {
            $label.addClass('selected');
        } else {
            $label.removeClass('selected');
        }
    });
    // Msg alerta
    setTimeout(function() {
        $('.alert-fixed-top').alert('close');
    }, 3500);
    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();
    // Progressive enhancement
    $('#filtro-semana, #filtro-status, #filtro-dev').on('change', function() {
        $('#filtro-form').submit();
    });
    // Abrir modal de visualização tarefa
    $('.btn-view').on('click', function(e){
        e.preventDefault();
        var tarefaId = $(this).data('tarefa-id');
        $('#viewModal'+tarefaId).modal('show');
    });
    // Exportar PDF
    $('#btn-export-pdf').on('click', function(){
        var params = $('#filtro-form').serialize();
        window.open("{{ route('tarefas.exportPdf') }}?" + params, '_blank');
    });
});
</script>
@endsection
