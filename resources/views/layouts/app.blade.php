<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>PontuaDev | @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Resets */
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        a,
        a:hover,
        a:visited,
        a:active,
        a:focus {
            text-decoration: none;
        }
        a:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(25,121,206,0.12);
            border-radius: 3px;
        }
        html {
            scroll-behavior: smooth;
        }
        .btn-primary,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active,
        .bg-primary,
        .alert-primary,
        .badge-primary,
        .border-primary {
            background-color: #3b85d4 !important;
            color: #fff !important;
            border-color: #3b85d4 !important;
        }
        .btn-primary:hover,
        .btn-primary:focus:hover,
        .btn-primary:active:hover {
            background-color: #1c6eb6 !important;
            border-color: #1c6eb6 !important;
        }
        .btn-outline-primary {
            color: #3b85d4 !important;
            border-color: #3b85d4 !important;
        }
        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            color: #fff !important;
        }
        .btn-edit.btn-outline-primary:hover,
        .btn-edit.btn-outline-primary:focus {
            color: #1979ce !important;
        }
        .btn-edit.btn-outline-primary:hover .bi,
        .btn-edit.btn-outline-primary:focus .bi {
            color: #1979ce !important;
        }
        a.text-primary,
        .text-primary {
            color: #3b85d4 !important;
        }
        a.text-primary:hover,
        .text-primary:hover {
            color: #1c6eb6 !important;
        }
        .pagination .page-item.active .page-link {
            background-color: #3b85d4 !important;
            border-color: #3b85d4 !important;
            color: #fff !important;
        }
        .page-link:hover {
            color: #1c6eb6 !important;
        }
        .badge-primary {
            background-color: #3b85d4 !important;
            color: #fff !important;
        }
        /* Lista devs/tarefas */
        .btn-adicionar-dev {
            width: 100%;
            max-width: 1100px;
            margin-top: 1rem;
            margin-bottom: 1rem;
            padding: 1rem 3rem;
            border-radius: 8px;
            font-size: 1.5rem;
            display: block;
        }
        .btn-adicionar-dev:hover,
        .btn-adicionar-dev:focus {
            background-color: #3b85d4 !important;
        }
        .card-dev {
            width: 100%;
            max-width: 1100px;
            font-size: 1.2rem;
            margin: 0 auto;
        }
        .dev-actions {
            gap: 1rem;
            margin-top: -1rem;
            margin-left: 10.2rem;
            padding-bottom: 0.5rem;
        }
        .dev-actions .btn-view {
            font-size: 1rem;
            background: #d1f4ff;
            color: #0c5460;
            border: none;
            min-width: 48px;
            min-height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dev-actions .btn-edit {
            font-size: 1rem;
            background: #cde4ff;
            color: #1979ce;
            border: none;
            min-width: 48px;
            min-height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dev-actions .btn-delete {
            font-size: 1rem;
            background: #ffcece;
            color: #d42828;
            border: none;
            min-width: 48px;
            min-height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        table .dev-actions {
            margin-left: 0 !important;
            margin-top: 0 !important;
            padding-bottom: 0.5rem;
            gap: 0.5rem;
        }
        .dev-actions .btn-sm {
            min-width: 34px;
            min-height: 34px;
            font-size: 1rem;
            padding: 0.25rem 0.5rem;
        }
        .dev-actions .btn-view:hover, .dev-actions .btn-edit:hover, .dev-actions .btn-delete:hover {
            filter: brightness(0.95);
        }
        .transition-chevron {
            transition: transform 0.3s cubic-bezier(.4,2,.6,1);
            display: inline-block;
        }
        .pontuacao-list-devs .list-group-item {
            font-size: 1.25rem;
            font-weight: 500;
            border: none;
            padding-bottom: 1rem;
        }
        .pontuacao-list-devs .pontuacao-topico {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .pontuacao-list-devs .bi-question-circle {
            font-size: 1.0em;
            vertical-align: middle;
            margin-left: 0.5rem;
        }
        .pontuacao-list-devs .pontuacao-valor {
            font-size: 1.6rem;
            margin-left: 0;
            margin-top: 0.5rem;
        }
        .pontuacao-list-tarefas {
            font-size: 1.25rem;
            font-weight: 500;
            border: none;
            padding-bottom: 1rem;
        }
        .pontuacao-list-tarefas .pontuacao-topico {
            display: flex;
            align-items: center;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 500;
        }
        .pontuacao-list-tarefas .bi-question-circle {
            font-size: 1.1em;
            vertical-align: middle;
            margin-left: 0.5rem;
        }
        .pontuacao-list-tarefas .pontuacao-valor {
            font-size: 1.7rem;
            margin-left: 0;
            margin-top: 0.5rem;
            font-weight: 500;
        }
        .pontuacao-list-tarefas .avatar-metrica {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: -2rem;
            object-fit: cover;
        }
        /* Classificação de métricas */
        .posicao-bookmark {
            position: relative;
            transform-origin: center top;
            transition: transform 0.2s;
            z-index: 2;
        }
        .posicao-bookmark-1 {
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.5);
        }
        .posicao-bookmark-2 {
            box-shadow: 0 4px 12px rgba(192, 192, 192, 0.5);
        }
        .posicao-bookmark-3 {
            box-shadow: 0 3px 10px rgba(205, 127, 50, 0.5);
        }
        /* Table zebra striping */
        .table-zebra tbody tr:nth-of-type(even):not(:first-child) {
            background-color: #f7f9fb;
        }
        .table-zebra thead tr {
            background-color: #f7f9fb;
        }
        /* Add/Edit devs/tarefas */
        .add-edit-card-dev {
            max-width: 700px;
            width: 100%;
            margin-top: 1rem;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
        }
        .add-edit-card-tarefa {
            max-width: 1000px;
            width: 100%;
            margin-top: 1rem;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
        }
        .add-edit-title {
            font-size: 1.5rem;
        }
        .add-edit-lbl {
            font-size: 1.1rem;
        }
        .add-edit-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        .add-edit-actions .btn {
            min-width: 140px;
            font-size: 1.15rem;
            margin-top: 1rem;
            padding: 0.7rem 1.5rem;
        }
        /* Filtros */
        .filtros-avancados-box {
            border: 1.5px solid #e3e6ea;
            border-radius: 18px;
            background: #fafbfc;
            padding: 0.6rem 1.2rem 1.5rem 1.5rem;
            margin-top: 1.8rem;
            margin-bottom: 0.5rem;
        }
        .filtro-badge {
            display: inline-flex;
            align-items: center;
            border: 2px solid #e3e6ea;
            border-radius: 1.2rem;
            padding: 0.5rem 1.1rem;
            font-size: 1.08rem;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            box-shadow: none;
            margin-bottom: 0.5rem;
            min-width: unset;
            margin-right: 0.7rem;
        }
        .filtro-badge.selected {
            border-color: #1979ce !important;
            box-shadow: 0 2px 8px rgba(25,121,206,0.12);
            background: #e6f0ff !important;
        }
        .filtro-badge .badge {
            margin-right: 0;
        }
        .filtro-dev {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            border: 2px solid #e3e6ea;
            border-radius: 1.2rem;
            padding: 0.5rem 1.1rem;
            font-size: 1.08rem;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: none;
            margin-bottom: 0.5rem;
            min-width: 160px;
        }
        .filtro-dev.selected {
            border-color: #1979ce;
            box-shadow: 0 2px 8px rgba(25,121,206,0.12);
            background: #e6f0ff;
        }
        .filtro-dev img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
        }
        .filtro-badge input[type="checkbox"], .filtro-dev input[type="checkbox"] {
            display: none;
        }
        .filtro-desativado {
            opacity: 0.5;
            pointer-events: none;
        }
        .avatar-metrica {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }
        .custom-switch .custom-control-label::before {
            height: 1.6rem;
            width: 3.2rem;
            border-radius: 1.5rem;
            background: #e3e6ea;
            border: 2px solid #bfc4c9;
            top: 0.1rem;
            left: -2.5rem;
        }
        .custom-switch .custom-control-label::after {
            height: 1.1rem;
            width: 1.1rem;
            border-radius: 50%;
            top: 0.35rem;
            left: -2.2rem;
            background: #fafbfc;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            transition: left 0.2s cubic-bezier(.4,1,.6,1);
        }
        .custom-switch .custom-control-input:checked~.custom-control-label::after {
            left: -1.3rem;
            background: #fafbfc;
        }
        .custom-switch .custom-control-input:checked~.custom-control-label::before {
            background-color: #1979ce;
            border-color: #1979ce;
        }
        .custom-control.custom-switch {
            z-index: 1;
            position: relative;
        }
        #filtro-data-col {
            z-index: 2;
            position: relative;
        }
        /* Badges status */
        .badge-status-zerou {
            background: #f2f2f2;
            color: #6c757d;
            font-weight: 600;
        }
        .badge-status-saiualgo {
            background: #fff7e6;
            color: #b8860b;
            font-weight: 600;
        }
        .badge-status-quase {
            background: #e6f0ff;
            color: #1979ce;
            font-weight: 600;
        }
        .badge-status-deubom {
            background: #e6ffe6;
            color: #218838;
            font-weight: 600;
        }
        .badge-status-extra {
            background: #e6e6ff;
            color: #5a32c2;
            font-weight: 600;
        }
        /* Modal excluir/visualizar */
        .modal-title {
            font-size: 1.45rem;
            font-weight: 600;
        }
        .modal-content .modal-body {
            font-size: 1.3rem;
        }
        .modal-content .modal-footer {
            border-top: none;
            gap: 1rem;
            margin-bottom: 1.5rem;
            margin-right: 1rem;
        }
        .modal-content .modal-footer .btn {
            font-size: 1.1rem;
            min-width: 120px;
            padding: 0.6rem 1.2rem;
        }
        .modal-content .modal-footer .btn-secondary {
            background: #6c757d;
            color: #ffffff;
            border: none;
        }
        .modal-content .modal-footer .btn-danger {
            background: #d42828;
            color: #ffffff;
            border: none;
        }
        .modal-content .modal-footer .btn-secondary:hover {
            filter: brightness(0.92);
        }
        .modal-content .modal-footer .btn-danger:hover {
            filter: brightness(0.92);
        }
        /* Msg alerta */
        .alert-fixed-top {
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1055;
            min-width: 420px;
            max-width: 90vw;
            border-radius: 8px;
        }
        @media (max-width: 600px) {
            .alert-fixed-top { min-width: 90vw; left: 5vw; transform: none; }
        }
        /* Breadcrumb */
        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: #6c757d;
            padding-left: 0.7rem;
            padding-right: 1rem;
        }
        /* Botão Voltar ao topo */
        #botao-topo {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #1979ce;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        #botao-topo.visivel {
            opacity: 0.9;
            visibility: visible;
        }
        #botao-topo:hover {
            background-color: #1466ad;
            opacity: 1;
        }
        /* Footer */
        .btn-repo { color: #fff; text-decoration: none; display: inline-flex; align-items: center; gap: 0.45rem; transition: color .12s ease; }
        .btn-repo .repo-arrow { display: inline-block; transition: transform .18s cubic-bezier(.2,.9,.3,1); }
        .btn-repo:hover, .btn-repo:hover .repo-arrow, .btn-repo:focus .repo-arrow { transform: translateX(6px); color: #3b85d4; }
        .btn-repo:focus { outline: none; box-shadow: 0 0 0 3px rgba(59,132,212,0.12); border-radius: 6px; }
    </style>
</head>
<body>
    <!-- Logo -->
    <div class="text-center my-4">
        <svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
            <image href="{{ asset('img/PontuaDev.svg') }}" width="200" height="200" />
        </svg>
    </div>

    <!-- Botão Voltar ao Topo -->
    <div id="botao-topo" data-toggle="tooltip" data-placement="left" title="Voltar ao topo">
        <i class="bi bi-arrow-up" style="font-size: 1.5rem;"></i>
    </div>
    
    <div class="container">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            // Tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Botão Voltar ao Topo
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#botao-topo').addClass('visivel');
                } else {
                    $('#botao-topo').removeClass('visivel');
                }
            });
            
            $('#botao-topo').click(function() {
                $('html, body').animate({scrollTop : 0}, 500);
                return false;
            });
            
            // Carregar corretamente o estado do botão ao iniciar a página
            if ($(window).scrollTop() > 300) {
                $('#botao-topo').addClass('visivel');
            }
        });
    </script>
    
    @yield('scripts')
    
    <!-- Footer -->
    <footer style="background:#222; color:#fff; margin-top:6rem; padding:2.2rem 0 0 0; margin-bottom:0;">
        <div style="max-width:1100px; margin:0 auto; padding:0 2rem;">
            <div style="display:flex; align-items:flex-start; gap:3.5rem; justify-content:center; text-align:left;">
                <div style="flex:0 0 220px; display:flex; flex-direction:column; align-items:flex-start; justify-content:center;">
                    <img src="{{ asset('img/PontuaDevBranca.svg') }}" alt="PontuaDev" style="height:70px; margin-bottom:0.7rem;">
                    <div style="font-size:1.15rem; font-weight:700; letter-spacing:1px; margin-bottom:0.2rem;">PontuaDev</div>
                    <div style="font-size:1rem; color:#bbb; margin-bottom:1.2rem;">Sistema de pontuação de tarefas semanais do departamento de dev's.</div>
                </div>
                <div style="flex:1; display:flex; gap:3.5rem; justify-content:flex-start;">
                    <div style="display:flex; flex-direction:column; gap:0.3rem; align-items:flex-start;">
                        <div style="font-size:1.08rem; font-weight:600; color:#fff;">Sobre</div>
                        <a href="https://github.com/juletopi/JCPC_Portfolio" target="_blank" style="color:#bbb; text-decoration:none; font-size:1rem;">Portfolio</a>
                        <a href="https://github.com/juletopi" target="_blank" style="color:#bbb; text-decoration:none; font-size:1rem;">GitHub</a>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:0.3rem; align-items:flex-start;">
                        <div style="font-size:1.08rem; font-weight:600; color:#fff;">Redes</div>
                        <a href="https://www.facebook.com/juhletopi/" target="_blank" style="color:#bbb; text-decoration:none; font-size:1rem;">Facebook</a>
                        <a href="https://www.instagram.com/juletopi/" target="_blank" style="color:#bbb; text-decoration:none; font-size:1rem;">Instagram</a>
                        <a href="https://www.linkedin.com/in/julio-cezar-pereira-camargo/" target="_blank" style="color:#bbb; text-decoration:none; font-size:1rem;">LinkedIn</a>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:0.3rem; align-items:flex-start;">
                        <div style="font-size:1.08rem; font-weight:600; color:#fff;">Contato</div>
                        <a href="mailto:juliocezarpvh@hotmail.com" style="color:#bbb; text-decoration:none; font-size:1rem;">E-mail</a>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:0.3rem; align-items:flex-start;">
                        <div style="font-size:1.08rem; color:#bbb;">Quer accesar o código-fonte do projeto?<br></div>
                        <a class="btn-repo" href="https://github.com/juletopi/PontuaDev_Project" style="font-size:1rem; background:transparent;" target="_blank" rel="noopener">
                            <strong>Ver repositório</strong>
                            <i class="bi bi-arrow-right repo-arrow" aria-hidden="true" style="font-size:1rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom" style="background-color:#181818; padding:1.5rem 0; margin-top:2rem;">
            <div style="max-width:1100px; margin:0 auto; padding:0 2rem;">
                <div style="display:flex; flex-direction:column; align-items:center; gap:0;">
                    <p style="font-size:0.98rem; margin:0; padding:0; color:#bbb;">Alguns direitos reservados &copy; <span id="current-year">{{ date('Y') }}</span> &#xa0;┃&#xa0; Feito com <i class="bi bi-suit-heart-fill" style="font-size:0.85rem;" aria-hidden="true"></i> e <i class="bi bi-cup-hot-fill" style="font-size:0.85rem;" aria-hidden="true"></i> por Juletopi</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
