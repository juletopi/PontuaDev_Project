@extends('layouts.app')

@section('title', 'Lista de Devs')

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
            <li class="breadcrumb-item active" aria-current="page">Lista de devs</li>
        </ol>
    </nav>

    <!-- Btn add dev -->
    <div class="row justify-content-center mb-4">
        <div class="col-12 d-flex justify-content-center">
            <a href="{{ route('devs.create') }}" class="btn btn-primary btn-lg btn-adicionar-dev">
                <i class="bi bi-plus-circle"></i> Adicionar dev
            </a>
        </div>
    </div>

    <!-- Dev card -->
    <div class="row justify-content-center">
        @foreach($devs as $dev)
            <div class="col-12 d-flex justify-content-center mb-5">
                <div class="card shadow-lg card-dev">
                    <div class="card-body d-flex align-items-center">
                        @php
                            $avatar = $dev->avatar
                                ? asset('storage/' . $dev->avatar)
                                : 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg';
                            $borda = $dev->faixa && isset(\App\Models\Dev::$faixaCores[$dev->faixa])
                                ? \App\Models\Dev::$faixaCores[$dev->faixa]
                                : '#ccc';
                        @endphp
                        <div style="position: relative; display: inline-block;">
                            @if($dev->avatar)
                                <img src="{{ $avatar }}"
                                     alt="avatarDev"
                                     class="rounded-circle mr-4"
                                     style="width:120px; height:120px; border: 6px solid {{ $borda }}; background: #f8f9fa; object-fit:cover;">
                            @else
                                <span class="rounded-circle mr-4 d-flex align-items-center justify-content-center" style="width:120px; height:120px; background: #f8f9fa; font-size:4rem; color:#bbb;">
                                    <i class="bi bi-person-circle" style="font-size:7.4rem;"></i>
                                </span>
                            @endif
                            @if($dev->faixa)
                                <img src="{{ asset('img/faixas/faixa' . ucfirst($dev->faixa) . '.svg') }}"
                                     alt="faixa"
                                     style="position: absolute; top: 80px; right: 18px; width: 40px; height: 40px; background: #fff; border-radius: 50%; border: 2px solid #eee;">
                            @endif
                        </div>
                        <div>
                            <h4 class="mb-1">{{ $dev->nome }}</h4>
                            <div class="text-muted mb-1">{{ $dev->cargo }}
                                @if($dev->data_inicio)
                                    · {{ $dev->tempo_experiencia }}
                                @endif
                            </div>
                            <div class="text-muted">{{ $dev->email }}</div>
                        </div>
                        <button class="btn btn-link ml-auto toggle-chevron" type="button" 
                            data-toggle="collapse" data-target="#devCollapse{{ $dev->id }}" 
                            aria-expanded="false" aria-controls="devCollapse{{ $dev->id }}">
                            <i class="bi bi-chevron-up transition-chevron" id="chevron-{{ $dev->id }}"></i>
                        </button>
                    </div>
                    
                    <!-- Opc dev -->
                    <div class="mb-3 d-flex align-items-center dev-actions">
                        <a href="{{ route('devs.edit', $dev->id) }}" class="btn-edit btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn-delete btn-outline-danger" title="Deletar" data-toggle="modal" data-target="#modalExcluirDev{{ $dev->id }}">
                            <i class="bi bi-trash"></i>
                        </button>

                        <!-- Modal excluir dev -->
                        <div class="modal fade" id="modalExcluirDev{{ $dev->id }}" tabindex="-1" role="dialog" aria-labelledby="modalExcluirDevLabel{{ $dev->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalExcluirDevLabel{{ $dev->id }}">
                                            <i class="bi bi-trash"></i> Excluir dev
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Deseja excluir o dev?<br><br>Essa ação é irreversível e excluirá todas as informações das tarefas referentes ao dev.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('devs.destroy', $dev->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dev collapse -->
                    <div class="collapse" id="devCollapse{{ $dev->id }}">
                        <div class="card-body border-top">
                            <ul class="nav nav-tabs" id="devTab{{ $dev->id }}" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pontuacao-tab-{{ $dev->id }}" data-toggle="tab" href="#pontuacao{{ $dev->id }}" role="tab" aria-controls="pontuacao{{ $dev->id }}" aria-selected="true">
                                        Pontuação
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tarefas-tab-{{ $dev->id }}" data-toggle="tab" href="#tarefas{{ $dev->id }}" role="tab" aria-controls="tarefas{{ $dev->id }}" aria-selected="false">
                                        Tarefas
                                    </a>
                                </li>
                            </ul>
                            <!-- Pontuação tab -->
                            <div class="tab-content pt-3" id="devTabContent{{ $dev->id }}">
                                <div class="tab-pane fade show active" id="pontuacao{{ $dev->id }}" role="tabpanel" aria-labelledby="pontuacao-tab-{{ $dev->id }}">
                                    <ul class="list-group list-group-flush pontuacao-list-devs">
                                        <li class="list-group-item">
                                            <div class="pontuacao-topico">
                                                <span>Média geral</span>
                                                <i class="bi bi-question-circle" data-toggle="tooltip" data-placement="right" title="Média de todas as pontuações das tarefas semanais já feitas por este dev"></i>
                                            </div>
                                            <span class="pontuacao-valor">
                                                {{ isset($dev->media_geral) ? number_format($dev->media_geral, 1) : '--' }} <small class="text-muted">pts</small>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="pontuacao-topico">
                                                <span>Total de pontos</span>
                                                <i class="bi bi-question-circle" data-toggle="tooltip" data-placement="right" title="Soma de todos os pontos das tarefas semanais já feitas por este dev"></i>
                                            </div>
                                            <span class="pontuacao-valor">
                                                {{ isset($dev->total_pontos) ? $dev->total_pontos : '--' }} <small class="text-muted">pts</small>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="pontuacao-topico">
                                                <span>Porcentagem de aproveitamento</span>
                                                <i class="bi bi-question-circle" data-toggle="tooltip" data-placement="right" title="Percentual de aproveitamento baseado no máximo possível de pontos de todas as tarefas semanais feitas por este dev"></i>
                                            </div>
                                            <span class="pontuacao-valor">
                                                {{ isset($dev->porcentagem_aproveitamento) ? $dev->porcentagem_aproveitamento : '--' }} <small class="text-muted">%</small>
                                            </span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tarefas tab -->
                                <div class="tab-pane fade" id="tarefas{{ $dev->id }}" role="tabpanel" aria-labelledby="tarefas-tab-{{ $dev->id }}">
                                    <div id="tarefas-list-{{ $dev->id }}">
                                        <table class="table table-borderless table-zebra">
                                            <thead>
                                                <tr>
                                                    <th style="width:100px;">Semana</th>
                                                    <th>Tarefa</th>
                                                    <th style="width:150px;">Status</th>
                                                    <th style="width:70px;">Pontos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $statusMap = [0=>'Zerou',2=>'Saiu algo',3=>'Quase',5=>'Deu bom',8=>'Extra'];
                                                @endphp
                                                @foreach($dev->tarefas_paginadas as $tarefa)
                                                    <tr>
                                                        <td>[{{ $tarefa->numero_semana }}]</td>
                                                        <td>{{ $tarefa->nome_tarefa }}</td>
                                                        <td>
                                                            <span class="badge
                                                                @if($tarefa->pontuacao == 0) badge-status-zerou
                                                                @elseif($tarefa->pontuacao == 2) badge-status-saiualgo
                                                                @elseif($tarefa->pontuacao == 3) badge-status-quase
                                                                @elseif($tarefa->pontuacao == 5) badge-status-deubom
                                                                @elseif($tarefa->pontuacao == 8) badge-status-extra
                                                                @else badge-secondary @endif"
                                                                style="font-size:1rem;">
                                                                {{ $statusMap[$tarefa->pontuacao] ?? '-' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $tarefa->pontuacao }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Paginação tarefas -->
                                        <nav class="d-flex justify-content-center align-items-center" style="gap:0.5rem; margin-top:2.5rem; margin-bottom:1rem;">
                                            <ul class="pagination mb-0" style="font-size:0.95rem;">
                                                <li class="page-item {{ $dev->tarefas_paginadas->onFirstPage() ? 'disabled' : '' }}">
                                                    <a class="page-link" href="#" onclick="carregarTarefas({{ $dev->id }}, {{ $dev->tarefas_paginadas->currentPage() - 1 }}); return false;">Anterior</a>
                                                </li>
                                                <li class="page-item">
                                                    <span class="page-link">{{ $dev->tarefas_paginadas->currentPage() }}</span>
                                                </li>
                                                <li class="page-item {{ !$dev->tarefas_paginadas->hasMorePages() ? 'disabled' : '' }}">
                                                    <a class="page-link" href="#" onclick="carregarTarefas({{ $dev->id }}, {{ $dev->tarefas_paginadas->currentPage() + 1 }}); return false;">Próximo</a>
                                                </li>
                                            </ul>
                                            <a href="{{ route('tarefas.index', $dev->id) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center" style="height:35px; font-size:1rem; gap:0.2rem; margin-left:0.5rem;">
                                                <i class="bi bi-search" style="font-size:1.1rem;"></i> Ver mais
                                            </a>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
<script>
    $(function() {
        // Tooltips
        $('[data-toggle="tooltip"]').tooltip();
        $('.collapse').on('show.bs.collapse', function () {
            var btn = $('[data-target="#' + this.id + '"]');
            var icon = btn.find('i');
            icon.css({transform: 'rotate(180deg)'});
        });
        $('.collapse').on('hide.bs.collapse', function () {
            var btn = $('[data-target="#' + this.id + '"]');
            var icon = btn.find('i');
            icon.css({transform: 'rotate(0deg)'});
        });
        // Msg alerta
        setTimeout(function() {
            $('.alert-fixed-top').alert('close');
        }, 3500);
    });
    // Paginação AJAX
    function carregarTarefas(devId, pagina) {
        $.get('/devs/' + devId + '/tarefas?page=' + pagina, function(html) {
            $('#tarefas-list-' + devId).html(html);
        });
    }
</script>
@endsection
