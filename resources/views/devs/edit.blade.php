@extends('layouts.app')

@section('title', 'Editar Dev')

@section('content')
    <!-- Breadcrumb nav -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('devs.index') }}">Lista de devs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar dev</li>
        </ol>
    </nav>

    <!-- Edit dev container -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 d-flex justify-content-center">
            <div class="card shadow-lg card-dev add-edit-card-dev p-4">
                <h2 class="mb-4 add-edit-title">
                    <i class="bi bi-pencil"></i> Editar dev
                </h2>
                <form method="POST" action="{{ route('devs.update', $dev->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group text-center">
                        <label for="avatar" class="d-block mb-2">Avatar</label>
                        <div id="avatar-dropzone" class="mb-3" style="width:140px; height:140px; margin:0 auto; border: 2px dashed #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #f8f9fa; position: relative; cursor: pointer;">
                            <div style="position: relative; display: inline-block;">
                                <img id="avatar-preview" src="{{ $dev->avatar ? asset('storage/' . $dev->avatar) : 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-circle.svg' }}" alt="avatar" style="width:120px; height:120px; border-radius: 50%; object-fit: cover;">
                                <img id="faixa-badge-preview" src="{{ $dev->faixa ? asset('img/faixas/faixa' . ucfirst($dev->faixa) . '.svg') : 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/plus-circle-dotted.svg' }}" alt="faixa" style="position: absolute; top: 70px; right: -25px; width: 50px; height: 50px; background: #f8f9fa; border-radius: 50%; border: 2px solid #eee;">
                                <input type="file" name="avatar" id="avatar" accept="image/*" style="opacity:0; position:absolute; width:100%; height:100%; left:0; top:0; cursor:pointer;">
                            </div>
                        </div>
                        <small class="form-text text-muted">Clique ou arraste uma imagem para fazer upload</small>
                    </div>
                    <div class="form-group add-edit-lbl">
                        <label for="nome">Nome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $dev->nome) }}" required>
                    </div>
                    <div class="form-group add-edit-lbl">
                        <label for="cargo">Cargo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo', $dev->cargo) }}" required>
                    </div>
                    <div class="form-group add-edit-lbl">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $dev->email) }}">
                    </div>
                    <div class="form-group add-edit-lbl">
                        <label for="data_inicio">Experiência (data inicial)</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ old('data_inicio', $dev->data_inicio) }}">
                    </div>
                    <div class="form-group add-edit-lbl">
                        <label for="faixa">Faixa</label>
                        <select class="form-control" id="faixa" name="faixa">
                            <option value="">Selecione a faixa</option>
                            @foreach(\App\Models\Dev::$faixas as $faixa)
                                <option value="{{ $faixa }}" {{ old('faixa', $dev->faixa) == $faixa ? 'selected' : '' }}>{{ ucfirst($faixa) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-edit-actions mt-4">
                        <a href="{{ route('devs.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-pencil"></i> Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Preview avatar
    $('#avatar').change(function(e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (ev) {
                $('#avatar-preview').attr('src', ev.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    // Preview faixa
    document.getElementById('faixa').addEventListener('change', function(e) {
        var faixa = e.target.value;
        var badge = document.getElementById('faixa-badge-preview');
        var select = document.getElementById('faixa');
        var cores = {
            branca: '#eaeaea',
            amarela: '#ffe066',
            vermelha: '#ff6f6f',
            laranja: '#ffb366',
            verde: '#7ed957',
            roxa: '#b980f0',
            marrom: '#a9746e',
            preta: '#222'
        };
        if (faixa) {
            badge.src = '/img/faixas/faixa' + faixa.charAt(0).toUpperCase() + faixa.slice(1) + '.svg';
            select.classList.remove('is-invalid');
            select.style.borderColor = cores[faixa] || '#ccc';
        } else {
            badge.src = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/plus-circle-dotted.svg';
            select.style.borderColor = '';
        }
    });
    // Trigger preview faixa borda
    window.addEventListener('DOMContentLoaded', function() {
        var faixa = document.getElementById('faixa');
        if(faixa.value) faixa.dispatchEvent(new Event('change'));
    });
    // Drag/drop
    $('#avatar-dropzone').on('dragover', function(e) {
        e.preventDefault();
        $(this).css('border-color', '#007bff');
    }).on('dragleave', function(e) {
        e.preventDefault();
        $(this).css('border-color', '#ccc');
    }).on('drop', function(e) {
        e.preventDefault();
        $(this).css('border-color', '#ccc');
        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#avatar').prop('files', files);
            var event = new jQuery.Event('change');
            $('#avatar').trigger(event);
        }
    });
</script>
@endsection

<style>
    #faixa:focus {
        box-shadow: none !important;
    }
</style>
