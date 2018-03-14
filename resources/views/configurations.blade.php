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
                    <a href="/profile">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="post" action="/configurations/addinscriptions" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10"><input type="text" name="description" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group ">
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
        filterPlaceHolder: 'Buscar',
        showFilterInputs: false
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
                    <a href="/profile">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="post" action="/configurations/addcolumn" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre del campo</label>
                        <div class="col-sm-10"><input type="text" name="columnName" class="form-control" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Etiqueta del campo</label>
                        <div class="col-sm-10"><input type="text" name="columnLabel" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tipo de dato</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="type" id="type" required>
                                <option value="integer">Número</option>
                                <option value="string">Texto</option>
                                <option value="timestamp">Fecha</option>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Campo obligatorio</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <input type="radio" name="columnRequired" id=option1" value="true" required>
                                <label for="columnRequired"> Si </label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="columnRequired" id="option2" value="false">
                                <label for="columnRequired"> No </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif


@endsection