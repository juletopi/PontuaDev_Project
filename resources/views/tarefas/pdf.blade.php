<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Tarefas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1a1a1a;
        }
        .container {
            max-width: 950px;
            background-color: #fff;
            padding: 32px 28px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.07);
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 18px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 6px;
        }
        .legend {
            font-weight: bold;
            font-size: 14px;
            color: #333;
            margin-bottom: 12px;
            padding: 5px 10px;
            background-color: #f5f5f5;
            border-left: 4px solid #1979ce;
            border-radius: 4px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 2rem;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
            font-size: 13px;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
            color: #1a1a1a;
            font-size: 14px;
        }
        .badge {
            border-radius: 1rem;
            padding: 2px 11px;
            font-size: 12px;
        }
        .badge-status-zerou {
            background: #f2f2f2 !important;
            color: #6c757d !important;
            font-weight: 600;
        }
        .badge-status-saiualgo {
            background: #fff7e6 !important;
            color: #b8860b !important;
            font-weight: 600;
        }
        .badge-status-quase {
            background: #e6f0ff !important;
            color: #1979ce !important;
            font-weight: 600;
        }
        .badge-status-deubom {
            background: #e6ffe6 !important;
            color: #218838 !important;
            font-weight: 600;
        }
        .badge-status-extra {
            background: #e6e6ff !important;
            color: #5a32c2 !important;
            font-weight: 600;
        }
        .pontuacao-box {
            background: #f5f5f5;
            border-radius: 4px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }
        .avatar-metrica {
            width: 40px;
            height: 40px;
            margin-right: 0.7rem;
            background: #f5f5f5;
        }
        .pontuacao-topico {
            font-size: 15px;
            color: #555;
        }
        .pontuacao-valor {
            font-size: 15px;
            font-weight: bold;
        }
        @media print {
            body { background: #fff !important; }
            .container { box-shadow: none; border-radius: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="margin-bottom:10px;">
                <img src="{{ public_path('img/PontuaDev.svg') }}" alt="PontuaDev" style="height:80px;">
            </div>
            <h1>Relatório de Tarefas</h1>
            <div style="font-size:13px; color:#888;">Emitido em {{ date('d/m/Y') }}</div>
        </div>
        <div class="legend">Lista de Tarefas</div>
        <table>
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Tarefa</th>
                    <th>Responsável</th>
                    <th style="min-width:80px;">Status</th>
                    <th>Pts</th>
                    <th>Período</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tarefas as $tarefa)
                @php
                    $badgeClass = '';
                    if($tarefa->pontuacao == 0) $badgeClass = 'badge-status-zerou';
                    elseif($tarefa->pontuacao == 2) $badgeClass = 'badge-status-saiualgo';
                    elseif($tarefa->pontuacao == 3) $badgeClass = 'badge-status-quase';
                    elseif($tarefa->pontuacao == 5) $badgeClass = 'badge-status-deubom';
                    elseif($tarefa->pontuacao == 8) $badgeClass = 'badge-status-extra';
                @endphp
                <tr>
                    <td>[{{ $tarefa->numero_semana }}]</td>
                    <td>{{ $tarefa->nome_tarefa }}</td>
                    <td>{{ $tarefa->dev ? $tarefa->dev->nome : '-----' }}</td>
                    <td style="min-width:90px;"><span class="badge {{ $badgeClass }}" style="font-family: Arial, sans-serif; font-size:13px; font-weight:600;">{{ $statusMap[$tarefa->pontuacao] ?? 'DOING' }}</span></td>
                    <td style="text-align:center;">{{ $tarefa->pontuacao ?? '--' }}</td>
                    <td>
                        {{ $tarefa->data_inicio ? \Carbon\Carbon::parse($tarefa->data_inicio)->format('d/m/Y') : '--/--/----' }}
                        -
                        {{ $tarefa->data_fim ? \Carbon\Carbon::parse($tarefa->data_fim)->format('d/m/Y') : '--/--/----' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="page-break-before: always;"></div>
        <div class="legend">Métricas do(s) Desenvolvedor(es)</div>
        <table style="width:100%; border:none; border-collapse:collapse; margin-bottom:1.5rem;">
            <thead>
                <tr style="background:none;">
                    <th style="border:none; font-size:13px; color:#555; text-align:left; padding-left:20px;">Dev</th>
                    <th style="border:none; font-size:13px; color:#555; text-align:left; padding-left:-15px;">Média</th>
                    <th style="border:none; font-size:13px; color:#555; text-align:left; padding-left:-15px;">Total</th>
                    <th style="border:none; font-size:13px; color:#555; text-align:left; padding-left:-15px;">Aproveitamento</th>
                    <th style="border:none; font-size:13px; color:#555; text-align:left;">Atividades</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devsFiltrados as $dev)
                <tr style="background:#f5f5f5;">
                    <td style="border:none; padding:12px 8px 12px 20px; display:flex; align-items:center; gap:1.1rem; margin-right:-1rem;">
                        @if($dev->avatar)
                            <img src="{{ public_path('storage/' . $dev->avatar) }}" class="avatar-metrica" style="border-radius:50%; width:40px; height:40px; background:#f5f5f5; margin-right:0.7rem;">
                        @else
                            <img src="{{ public_path('img/avatarDefault.svg') }}" class="avatar-metrica" style="border-radius:50%; width:40px; height:40px; background:#f5f5f5; color:#ccc; margin-right:0.7rem;">
                        @endif
                        <div>
                            <div style="font-size:14px; color:#1a1a1a; font-family: Arial, sans-serif; margin-top:2px;">{{ $dev->nome }}</div>
                            <div style="font-size:12px; color:#888; font-family: Arial, sans-serif;">{{ $dev->cargo }}</div>
                        </div>
                    </td>
                    <td style="border:none; padding:12px 0 8px -15px;">
                        <div style="font-size:1rem; color:#222;">{{ number_format($dev->media, 1) }} pts</div>
                        <div style="font-size:0.90rem; color:#888;">Média<br>selecionada</div>
                    </td>
                    <td style="border:none; padding:12px 0 12px -15px;">
                        <div style="font-size:1rem; color:#222;">{{ $dev->total }} pts</div>
                        <div style="font-size:0.90rem; color:#888;">Total de<br>pontos</div>
                    </td>
                    <td style="border:none; padding:12px 0 12px -15px;">
                        <div style="font-size:1rem; color:#222;">{{ $dev->porcentagem }}%</div>
                        <div style="font-size:0.90rem; color:#888;">Aproveitamento</div>
                    </td>
                    <td style="border:none; padding:12px 8px;">
                        <div style="font-size:1rem; color:#222;">{{ $tarefas->where('dev_id', $dev->id)->count() }}</div>
                        <div style="font-size:0.90rem; color:#888;">Atividades</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
