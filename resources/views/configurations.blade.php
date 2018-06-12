@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Configuración</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView == 'inscription')
            <li>
                Procesos de inscripción
            </li>
            <li class="active">
                <strong>Crear proceso de inscripción</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Tabla de usuarios de la organización
            </li>
            <li class="active">
                <strong>Crear columna</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView == 'inscription')

        <div class="title-action">
            <button type="submit" form="form-create" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </button>
        </div>
        @elseif($typeView == 'form')

        <div class="title-action">
            <button type="button" id="saveContinue" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar y nuevo
            </button>
            <button type="submit" form="form-create" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </button>
        </div>


        @endif
    </div>
</div>


@if($typeView == 'inscription')
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Registra la información <small>Inscripción.</small></h5>
                <div class="ibox-tools">
                    @if ($typeUser === null)
                    <a href="/profile/inscriptions">
                    @else
                    <a href="/wizard/costs">
                    @endif
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                <form method="post" action="/configurations/addinscriptions" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    @if ($typeUser !== null)
                    <input type="hidden" name="viewReturn" value="/wizard/costs">
                    @endif
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tipo de usuario</label>
                        <div class="col-sm-10">
                            @if ($typeUser === null)
                            <select class="form-control" name="type" id="type" required>
                                <option value="admin">Administrador</option>
                                <option value="master">Profesor / tutor</option>
                                <option value="student">Estudiante</option>
                            </select>
                            @else
                            <select class="form-control" name="type" id="type" required disabled>
                                @if ($typeUser === 'master')
                                    <option value="master">Profesor / tutor</option>
                                @else
                                    <option value="student">Estudiante</option>
                                @endif
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10"><input type="text" name="description" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group ">
                        <div class="col-sm-12">
                            @if ($typeUser !== null)
                            <a href="/configurations/create/{{ $typeUser }}" class="pull-right">
                            @else
                            <a href="/configurations/create/inscriptions" class="pull-right">
                            @endif
                                ¿No hay campos? Generalos desde aquí
                            </a>
                        </div>
                        <label class="col-sm-2 control-label">Datos a ingresar por las personas a inscribirse</label>
                        <div class="col-sm-10">
                            <select class="form-control dual_select" multiple name="columnsName[]">
                                @foreach($columns as $column)
                                    <option value="{{ $column->name }}">{{ $column->name . ' (' .$column->label.')' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dual Listbox -->
<script src="{{ asset('inspinia/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js') }}"></script>
<script type="text/javascript">
    $('.dual_select').bootstrapDualListbox({
        selectorMinimalHeight: 140,
        infoTextEmpty: 'Lista vacía',
        infoText: 'Mostrando todo {0}',
        infoTextFiltered: '<span class="label label-warning">Filtrando</span> {0} de {1}',
        moveAllLabel: 'Mover todo',
        removeAllLabel: 'Quitar todo',
        filterTextClear: 'Mostrar todo',
        filterPlaceHolder: 'Buscar'
    });
</script>

@elseif($typeView == 'form')
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Registra la información <small>Columna.</small></h5>
                <div class="ibox-tools">
                    @if ($viewReturn === null)
                    <a href="/profile/inscriptions">
                    @else
                    <a href="{{ $viewReturn }}">
                    @endif
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                <form method="post" action="/configurations/addcolumn" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    @if ($viewReturn !== null)
                    <input type="hidden" name="viewReturn" value="{{ $viewReturn }}">
                    @endif
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre del campo</label>
                        <div class="col-sm-10"><input type="text" name="columnName" class="form-control" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Etiqueta del campo</label>
                        <div class="col-sm-10"><input type="text" name="columnLabel" class="form-control" title="Este será el nombre visible del campo para los usuarios"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tipo de campo</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="type" id="type" required>
                                <option value="integer">Número</option>
                                <option value="string">Texto</option>
                                <option value="timestamp">Fecha</option>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Obligatorio</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <input type="radio" name="columnRequired" id="option1" value="true" required>
                                <label for="option1">Si</label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="columnRequired" id="option2" value="false">
                                <label for="option2">No</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Toastr -->
<script src="{{ asset('inspinia/js/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
    });

    $("#saveContinue").click(function(){
        var validado = $("#form-create").valid();
        if(validado) {
            $.ajax({
                url: "/configurations/addcolumn/new",
                data: $('#form-create').serialize(),
                dataType: "json",
                method: "POST",
                success: function(result)
                {
                    if (result.result === 'ok') {
                        toastr.success('Sigue trabajando.', 'El campo '+ result.column +' se ha creado.');
                    } else {
                        toastr.warning('Sigue trabajando.', 'El campo '+ result.column +' ya existe.');
                    }
                    $('#form-create')[0].reset();
                },
                error: function () {
                //alert("fallo");
                }
                
            });
        }
    });

    $('input[type="radio"]').click(function(){
        $('#columnRequired-error').remove();
    });
</script>
@endif

@include('layouts._script_spinner_code')
@endsection