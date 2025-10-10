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
        @foreach($tarefas as $tarefa)
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
<nav class="d-flex justify-content-center align-items-center" style="gap:0.5rem; margin-top:2.5rem; margin-bottom:1rem;">
    <ul class="pagination mb-0" style="font-size:0.95rem;">
        <li class="page-item {{ $tarefas->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="#" onclick="carregarTarefas({{ $dev->id }}, {{ $tarefas->currentPage() - 1 }}); return false;">Anterior</a>
        </li>
        <li class="page-item">
            <span class="page-link">{{ $tarefas->currentPage() }}</span>
        </li>
        <li class="page-item {{ !$tarefas->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="#" onclick="carregarTarefas({{ $dev->id }}, {{ $tarefas->currentPage() + 1 }}); return false;">Próximo</a>
        </li>
    </ul>
    <a href="{{ route('tarefas.index', $dev->id) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center" style="height:35px; font-size:1rem; gap:0.2rem; margin-left:0.5rem;">
        <i class="bi bi-search" style="font-size:1.1rem;"></i> Ver mais
    </a>
</nav>
