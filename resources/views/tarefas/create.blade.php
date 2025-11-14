@extends('layouts.app')

@section('title', 'Adicionar Tarefa')

@section('content')
    <!-- Breadcrumb nav -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('devs.index') }}">Lista de devs</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tarefas.index') }}">Lista de tarefas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Adicionar tarefa</li>
        </ol>
    </nav>

    <!-- Add task container -->
    <div class="row justify-content-center">
        <div class=".col-12 col-lg-10 flex justify-content-center">
            <div class="card shadow-lg card-dev add-edit-card-tarefa p-4">
                <h2 class="mb-4 add-edit-title">
                    <i class="bi bi-plus-circle"></i> Adicionar tarefa
                </h2>
                <form method="POST" action="{{ route('tarefas.store') }}">
                    @csrf
                    <div class="form-group col-md-6 add-edit-lbl" style="padding-left:0;">
                        <label for="dev_id">Dev responsável <span class="text-danger">*</span></label>
                        <div class="input-group align-items-center">
                            <div class="input-group-prepend">
                                <span class="input-group-text d-flex align-items-center justify-content-center" style="padding:0.33rem 0.5rem; background:none;">
                                    <i id="dev-avatar-preview" class="bi bi-person-circle" style="font-size:1.5rem; line-height:1; vertical-align:middle;"></i>
                                </span>
                            </div>
                            <select class="form-control" id="dev_id" name="dev_id" required>
                                <option value="">Selecione o dev</option>
                                @foreach(\App\Models\Dev::all() as $dev)
                                    <option value="{{ $dev->id }}" data-avatar="{{ $dev->avatar ? asset('storage/' . $dev->avatar) : 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg' }}">{{ $dev->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2 add-edit-lbl">
                            <label for="numero_semana">Nº da semana <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background:none;">[</span>
                                </div>
                                <input type="number" class="form-control" id="numero_semana" name="numero_semana" min="1" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background:none;">]</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col add-edit-lbl" style="margin-left:1rem;">
                            <label for="nome_tarefa">Nome da tarefa <span class="text-danger">*</span></label>
                            <textarea class="form-control auto-resize" id="nome_tarefa" name="nome_tarefa" required rows="1" style="overflow:hidden; resize:none;">{{ old('nome_tarefa') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group add-edit-lbl" style="padding-top:20px;">
                        <!-- Itens -->
                        <div class="list-header">
                            <label for="itens">Itens</label>
                            <div class="list-actions">
                                <button type="button" id="add-item-btn" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Adicionar item (Máx. 20)" aria-label="Adicionar item"><i class="bi bi-plus-lg" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div id="itens-list" class="mb-2">
                            <!-- inputs -->
                        </div>

                        <!-- Extras -->
                        <div class="list-header">
                            <label for="extras">Extra</label>
                            <div class="list-actions">
                                <button type="button" id="add-extra-btn" class="btn btn-sm btn-extra" data-toggle="tooltip" title="Adicionar extra (Máx. 5)" aria-label="Adicionar extra"><i class="bi bi-plus-lg" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div id="extras-list" class="mb-2">
                            <!-- inputs -->
                        </div>

                        <!-- Anotações -->
                        <label for="anotacao" style="padding-top:20px;">Anotações</label>
                        <textarea class="form-control" id="anotacao" name="anotacao" rows="3"></textarea>
                    </div>

                    <div class="form-row align-items-end">
                        <div class="form-group col-md-3 add-edit-lbl d-flex align-items-end">
                            <div style="width:100%;">
                                <label for="pontuacao">Pontuação</label>
                                <div class="input-group">
                                    @php $selectedPontuacao = old('pontuacao', ''); @endphp
                                    <select class="form-control" id="pontuacao" name="pontuacao">
                                        <option value="" {{ $selectedPontuacao === '' ? 'selected' : '' }}>DOING</option>
                                        <option value="0" {{ (string)$selectedPontuacao === '0' ? 'selected' : '' }}>Zerou</option>
                                        <option value="2" {{ (string)$selectedPontuacao === '2' ? 'selected' : '' }}>Saiu algo</option>
                                        <option value="3" {{ (string)$selectedPontuacao === '3' ? 'selected' : '' }}>Quase</option>
                                        <option value="5" {{ (string)$selectedPontuacao === '5' ? 'selected' : '' }}>Deu bom</option>
                                        <option value="8" {{ (string)$selectedPontuacao === '8' ? 'selected' : '' }}>Extra</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span id="pontuacao-pts" class="input-group-text" style="border:1.5px solid #ced4da; background:#fff; font-weight:500;">-- pts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-7 add-edit-lbl" style="margin-left:1rem;">
                            <label>Período <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <input type="date" class="form-control mr-2" id="data_inicio" name="data_inicio" required>
                                <span class="text-muted mx-2" style="font-size:1rem;">até</span>
                                <input type="date" class="form-control" id="data_fim" name="data_fim" style="margin-left:0.5rem;">
                            </div>
                        </div>
                    </div>
                    <div class="add-edit-actions mt-4">
                        <a href="{{ route('tarefas.index') }}" class="btn btn-cancel">Cancelar</a>
                        <button type="submit" class="btn btn-save"><i class="bi bi-plus-circle"></i> Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Preview avatar
    $('#dev_id').on('change', function() {
        var selected = $(this).find('option:selected');
        var avatar = selected.data('avatar');
        var $span = $(this).closest('.input-group').find('.input-group-text');
        if (avatar && avatar.indexOf('person-circle.svg') === -1) {
            $span.html('<img src="'+avatar+'" alt="avatar" style="width:25px; height:25px; border-radius:50%; object-fit:cover;">');
        } else {
            $span.html('<i id="dev-avatar-preview" class="bi bi-person-circle" style="font-size:1.5rem; line-height:1; vertical-align:middle;"></i>');
        }
    });
    // Preview pontuação
    function atualizarPreviewPontuacao() {
        var val = $('#pontuacao').val();
        var txt = '-- pts';
        if (val !== '') txt = val + ' pts';
        $('#pontuacao-pts').text(txt);
    }
    $('#pontuacao').on('change', atualizarPreviewPontuacao);
    atualizarPreviewPontuacao();

    // Comportamento auto-resize para textareas
    function autoResizeTextarea(el) {
        el.style.height = 'auto';
        el.style.height = (el.scrollHeight) + 'px';
    }
    $('.auto-resize').each(function(){ autoResizeTextarea(this); });
    $('.auto-resize').on('input', function(){ autoResizeTextarea(this); });

    // Dinâmica de itens e extras
    function createListItem(name, value) {
        var $input = $('<input type="text" class="form-control" name="'+name+'[]">').val(value||'');
        var $btn = $('<button type="button" class="btn btn-outline-danger remove-item-btn"><i class="bi bi-x"></i></button>');
        var $item = $('<div class="input-group list-item">')
            .append($input)
            .append($('<div class="input-group-append">').append($btn));
        return $item;
    }

    $('#add-item-btn').on('click', function(){
        var count = $('#itens-list .list-item').length;
        if (count >= 20) return; // limite
        var $new = createListItem('itens');
        $('#itens-list').append($new);
        $new.find('input').focus();
    });
    $('#add-extra-btn').on('click', function(){
        var count = $('#extras-list .list-item').length;
        if (count >= 5) return; // limite
        var $new = createListItem('extras');
        $('#extras-list').append($new);
        $new.find('input').focus();
    });

    $(document).on('click', '.remove-item-btn', function(){
        $(this).closest('.list-item').remove();
    });

    // On load foco no primeiro input de item ou extra
    $(function(){
        var $firstItem = $('#itens-list .list-item input:first');
        if ($firstItem.length) {
            $firstItem.focus();
            return;
        }
        var $firstExtra = $('#extras-list .list-item input:first');
        if ($firstExtra.length) $firstExtra.focus();
    });
</script>
@endsection
