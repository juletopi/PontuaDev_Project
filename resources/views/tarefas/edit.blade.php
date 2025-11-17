@extends('layouts.app')

@section('title', 'Editar Tarefa')

@section('content')

@php
    // Config values
    $maxItens = config('tarefa.max_itens', 10);
    $maxExtras = config('tarefa.max_extras', 5);
@endphp

    <!-- Breadcrumb nav -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('devs.index') }}">Lista de devs</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tarefas.index') }}">Lista de tarefas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar tarefa</li>
        </ol>
    </nav>

    <!-- Edit task container -->
    <div class="row justify-content-center">
        <div class=".col-12 col-lg-10 flex justify-content-center">
            <div class="card shadow-lg card-dev add-edit-card-tarefa p-4">
                <h2 class="mb-4 add-edit-title">
                    <i class="bi bi-pencil"></i> Editar tarefa
                </h2>
                <form method="POST" action="{{ route('tarefas.update', $tarefa->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-6 add-edit-lbl" style="padding-left:0;">
                        <label for="dev_id">Dev responsável <span class="text-danger">*</span></label>
                        <div class="input-group align-items-center">
                            <div class="input-group-prepend">
                                <span class="input-group-text d-flex align-items-center justify-content-center" style="padding:0.33rem 0.5rem; background:none;">
                                    @php
                                        $devSelected = $tarefa->dev;
                                        $avatar = $devSelected && $devSelected->avatar ? asset('storage/' . $devSelected->avatar) : 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg';
                                    @endphp
                                    @if($devSelected && $devSelected->avatar)
                                        <img id="dev-avatar-preview" src="{{ $avatar }}" alt="avatar" style="width:25px; height:25px; border-radius:50%; object-fit:cover;">
                                    @else
                                        <i id="dev-avatar-preview" class="bi bi-person-circle" style="font-size:1.5rem; line-height:1; vertical-align:middle;"></i>
                                    @endif
                                </span>
                            </div>
                            <select class="form-control" id="dev_id" name="dev_id" required>
                                <option value="">Selecione o dev</option>
                                @foreach(\App\Models\Dev::all() as $dev)
                                    <option value="{{ $dev->id }}" data-avatar="{{ $dev->avatar ? asset('storage/' . $dev->avatar) : 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg' }}" {{ $tarefa->dev_id == $dev->id ? 'selected' : '' }}>{{ $dev->nome }}</option>
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
                                <input type="number" class="form-control" id="numero_semana" name="numero_semana" min="1" required value="{{ old('numero_semana', $tarefa->numero_semana) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background:none;">]</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col add-edit-lbl" style="margin-left:1rem;">
                            <label for="nome_tarefa">Nome da tarefa <span class="text-danger">*</span></label>
                            <textarea class="form-control auto-resize" id="nome_tarefa" name="nome_tarefa" required rows="1" style="overflow:hidden; resize:none;">{{ old('nome_tarefa', $tarefa->nome_tarefa) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group add-edit-lbl" style="padding-top:20px;">
                        <!-- Itens -->
                        <div class="list-header">
                            <label for="itens">Itens</label>
                            <span class="items-counter" id="itens-counter" aria-live="polite" style="font-weight:600; margin-left:0.2rem;">0/{{ config('tarefa.max_itens', 10) }}</span>
                            <div class="list-actions">
                                <button type="button" id="add-item-btn" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Adicionar item" aria-label="Adicionar item"><i class="bi bi-plus-lg" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div id="itens-list" class="mb-2">
                                @if(old('itens'))
                                @foreach(old('itens') as $it)
                                    <div class="input-group list-item">
                                        <textarea class="form-control auto-resize" name="itens[]" placeholder="Digite um item..." rows="1" style="overflow:hidden; resize:none;">{{ $it }}</textarea>
                                        <div class="input-group-append"><button type="button" class="btn btn-outline-danger remove-item-btn"><i class="bi bi-x"></i></button></div>
                                    </div>
                                @endforeach
                            @elseif($tarefa->itens)
                                @foreach($tarefa->itens as $it)
                                    <div class="input-group list-item">
                                        <textarea class="form-control auto-resize" name="itens[]" placeholder="Digite um item..." rows="1" style="overflow:hidden; resize:none;">{{ $it }}</textarea>
                                        <div class="input-group-append"><button type="button" class="btn btn-outline-danger remove-item-btn"><i class="bi bi-x"></i></button></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Extras -->
                        <div class="list-header">
                            <label for="extras">Extra</label>
                            <span class="items-counter" id="extras-counter" aria-live="polite" style="font-weight:600; margin-left:0.2rem;">0/{{ config('tarefa.max_extras', 5) }}</span>
                            <div class="list-actions">
                                <button type="button" id="add-extra-btn" class="btn btn-sm btn-extra" data-toggle="tooltip" title="Adicionar extra" aria-label="Adicionar extra"><i class="bi bi-plus-lg" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div id="extras-list" class="mb-2">
                                @if(old('extras'))
                                @foreach(old('extras') as $ex)
                                    <div class="input-group list-item">
                                        <textarea class="form-control auto-resize" name="extras[]" placeholder="Digite um extra..." rows="1" style="overflow:hidden; resize:none;">{{ $ex }}</textarea>
                                        <div class="input-group-append"><button type="button" class="btn btn-outline-danger remove-item-btn"><i class="bi bi-x"></i></button></div>
                                    </div>
                                @endforeach
                            @elseif($tarefa->extras)
                                @foreach($tarefa->extras as $ex)
                                    <div class="input-group list-item">
                                        <textarea class="form-control auto-resize" name="extras[]" placeholder="Digite um extra..." rows="1" style="overflow:hidden; resize:none;">{{ $ex }}</textarea>
                                        <div class="input-group-append"><button type="button" class="btn btn-outline-danger remove-item-btn"><i class="bi bi-x"></i></button></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Anotações -->
                        <label for="anotacao" style="padding-top:20px;">Anotações</label>
                        <textarea class="form-control" id="anotacao" name="anotacao" rows="3">{{ old('anotacao', $tarefa->anotacao) }}</textarea>
                    </div>

                    <div class="form-row align-items-end">
                        <div class="form-group col-md-3 add-edit-lbl d-flex align-items-end">
                            <div style="width:100%;">
                                <label for="pontuacao">Pontuação</label>
                                <div class="input-group">
                                    @php $selectedPontuacao = old('pontuacao', $tarefa->pontuacao ?? ''); @endphp
                                    <select class="form-control" id="pontuacao" name="pontuacao">
                                        <option value="" {{ ($selectedPontuacao === '' || is_null($selectedPontuacao)) ? 'selected' : '' }}>DOING</option>
                                        @foreach($opcoesPontuacao as $valor => $label)
                                            <option value="{{ $valor }}" {{ (string)$selectedPontuacao === (string)$valor ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <span id="pontuacao-pts" class="input-group-text" style="border:1.5px solid #ced4da; background:#fff; font-weight:500;">{{ is_null($tarefa->pontuacao) ? '-- pts' : ($tarefa->pontuacao . ' pts') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-7 add-edit-lbl" style="margin-left:1rem;">
                            <label>Período <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <input type="date" class="form-control mr-2" id="data_inicio" name="data_inicio" required value="{{ old('data_inicio', optional($tarefa->data_inicio)->format('Y-m-d')) }}">
                                <span class="text-muted mx-2" style="font-size:1rem;">até</span>
                                <input type="date" class="form-control" id="data_fim" name="data_fim" style="margin-left:0.5rem;" value="{{ old('data_fim', optional($tarefa->data_fim)->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                    <div class="add-edit-actions mt-4">
                        <a href="{{ route('tarefas.index') }}" class="btn btn-cancel">Cancelar</a>
                        <button type="submit" class="btn btn-save"><i class="bi bi-pencil"></i> Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var MAX_ITENS = {{ $maxItens }};
    var MAX_EXTRAS = {{ $maxExtras }};

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
    $(document).on('input', '.auto-resize', function(){ autoResizeTextarea(this); });


    // Dinâmica de itens e extras
    function createListItem(name, value) {
        var placeholder = name === 'itens' ? 'Digite um item...' : 'Digite um extra...';
        var $textarea = $('<textarea class="form-control auto-resize" name="'+name+'[]" placeholder="'+placeholder+'" rows="1" style="overflow:hidden; resize:none;"></textarea>').val(value||'');
        var $btn = $('<button type="button" class="btn btn-outline-danger remove-item-btn"><i class="bi bi-x"></i></button>');
        var $item = $('<div class="input-group list-item">')
            .append($textarea)
            .append($('<div class="input-group-append">').append($btn));
        return $item;
    }

    var $lastFocusedInput = null;
    var $lastFocusedItensInput = null;
    var $lastFocusedExtrasInput = null;
    $(document).on('focusin', '#itens-list .list-item textarea', function(){
        $lastFocusedInput = $(this);
        $lastFocusedItensInput = $(this);
    });
    $(document).on('focusin', '#extras-list .list-item textarea', function(){
        $lastFocusedInput = $(this);
        $lastFocusedExtrasInput = $(this);
    });

    $('#add-item-btn').on('click', function(e){
        var count = $('#itens-list .list-item').length;
        if (count >= MAX_ITENS) {
            var $toFocus = $lastFocusedItensInput && $lastFocusedItensInput.length && $.contains(document, $lastFocusedItensInput[0]) ? $lastFocusedItensInput : $lastFocusedInput;
            if ($toFocus && $toFocus.length && $.contains(document, $toFocus[0])) {
                $toFocus.focus();
                try { var el = $toFocus[0]; if (el.setSelectionRange) { var len = el.value.length; el.setSelectionRange(len, len); } } catch(err){}
            }
            return; // limite
        }
        var $new = createListItem('itens');
        $('#itens-list').append($new);
        var $ta = $new.find('.auto-resize');
        if ($ta.length) { autoResizeTextarea($ta[0]); $ta.focus(); }
        updateCounters();
    });
    $('#add-extra-btn').on('click', function(e){
        var count = $('#extras-list .list-item').length;
        if (count >= MAX_EXTRAS) {
            var $toFocus = $lastFocusedExtrasInput && $lastFocusedExtrasInput.length && $.contains(document, $lastFocusedExtrasInput[0]) ? $lastFocusedExtrasInput : $lastFocusedInput;
            if ($toFocus && $toFocus.length && $.contains(document, $toFocus[0])) {
                $toFocus.focus();
                try { var el = $toFocus[0]; if (el.setSelectionRange) { var len = el.value.length; el.setSelectionRange(len, len); } } catch(err){}
            }
            return; // limite
        }
        var $new = createListItem('extras');
        $('#extras-list').append($new);
        var $ta = $new.find('.auto-resize');
        if ($ta.length) { autoResizeTextarea($ta[0]); $ta.focus(); }
        updateCounters();
    });

    $(document).on('click', '.remove-item-btn', function(){
        var $item = $(this).closest('.list-item');

        // On remove foco dos inputs ao remover
        var $nextInput = $item.nextAll('.list-item').first().find('textarea');
        var $prevInput = $item.prevAll('.list-item').first().find('textarea');
        if ($nextInput.length) {
            $nextInput.focus();
        } else if ($prevInput.length) {
            $prevInput.focus();
        }
        $item.remove();
        updateCounters();
    });

    // On load foco no primeiro textarea de item ou extra
    $(function(){
        var $firstItem = $('#itens-list .list-item textarea:first');
        if ($firstItem.length) {
            $firstItem.focus();
            return;
        }
        var $firstExtra = $('#extras-list .list-item textarea:first');
        if ($firstExtra.length) $firstExtra.focus();
    });

    // Atualiza os contadores e estado dos botões
    function updateCounters() {
        var itensCount = $('#itens-list .list-item').length;
        var extrasCount = $('#extras-list .list-item').length;
        $('#itens-counter').text(itensCount + '/' + MAX_ITENS);
        $('#extras-counter').text(extrasCount + '/' + MAX_EXTRAS);
        $('#add-item-btn').toggleClass('disabled', itensCount >= MAX_ITENS).attr('aria-disabled', itensCount >= MAX_ITENS);
        $('#add-extra-btn').toggleClass('disabled', extrasCount >= MAX_EXTRAS).attr('aria-disabled', extrasCount >= MAX_EXTRAS);
        $('#itens-list').toggleClass('list-empty', itensCount === 0);
        $('#extras-list').toggleClass('list-empty', extrasCount === 0);
    }

    // Init counters
    $(function(){
        updateCounters();
    });

    // Antes de enviar o form, remover itens/extras vazios e atualizar contadores
    $('form[action="{{ route('tarefas.update', $tarefa->id) }}"]').on('submit', function(){
        $('#itens-list textarea[name="itens[]"]').each(function(){
            var v = $(this).val() ? $(this).val().trim() : '';
            if (v === '') {
                $(this).closest('.list-item').remove();
            } else {
                $(this).val(v);
            }
        });
        $('#extras-list textarea[name="extras[]"]').each(function(){
            var v = $(this).val() ? $(this).val().trim() : '';
            if (v === '') {
                $(this).closest('.list-item').remove();
            } else {
                $(this).val(v);
            }
        });
        updateCounters();
    });
</script>
@endsection
