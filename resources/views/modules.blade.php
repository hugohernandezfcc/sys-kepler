@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Modulos</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Modulos de la organización</strong>
            </li>
            <li>
                <select class="inline" id="secciones" onchange="irSeccion()">
                    <option value="">--Seleccionar--</option>
                    <option value="/links">Enlaces</option>
                    <option value="/forums">Foro</option>
                    <option value="/articles">Articulos</option>
                    <option value="/walls">Muro</option>
                </select>
            </li>
            @elseif($typeView == 'form')
            <li>
                Modulos de la organización
            </li>
            <li class="active">
                @if($record->exists)
                    <strong>Editar modulo</strong>
                @else
                    <strong>Crear modulo</strong>
                @endif
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/modules/create" class="btn btn-primary btn-sm">Agregar modulo</a>
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



@if($typeView == 'form')
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Registra la información <small>modulo.</small></h5>
                <div class="ibox-tools">
                    <a href="/modules">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                @if($record->exists)
                <form method="post" action="/modules/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/modules/store" id="form-create" class="form-horizontal">
                @endif
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre del modulo</label>
                        <div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{ $record->name or old('name') }}" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Asignatura</label>
                        <div class="col-sm-10">
                            @if($subject->exists)
                                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                <select class="form-control" id="subject_id" disabled>
                                    @foreach ($to_related as $to)
                                        @if($subject->id == $to->id)
                                            <option value="{{$to->id}}" selected>{{$to->name}}</option>
                                            @break
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control" name="subject_id" id="subject_id">
                                    @foreach ($to_related as $to)
                                        @if($record->subject_id == $to->id)
                                            <option value="{{$to->id}}" selected>{{$to->name}}</option>
                                        @else
                                            <option value="{{$to->id}}">{{$to->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@elseif($typeView == 'list')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de modulos</h5>
                </div>
                <div class="ibox-content">
                    @include('layouts._spinner_code')

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Nombre del modulo</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td> 
                                        <a href="/modules/show/{{ $rec->id }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> 
                                    </td>
                                    <td>{{ $rec->name }}</td>
                                    <td>{{ $rec->created_at }}</td>
                                    <td>{{ $rec->user->name }}</td>
                                </tr>

                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th> - </th>
                                    <th>Nombre del modulo</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@elseif($typeView == 'view')
<input type="hidden" id="idRecord" value="{{ $record->id }}">
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            @include('layouts._spinner_code')
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        <div class="pull-right">
                            <a href="/modules/edit/{{ $record->id }}" class="btn btn-white btn-xs"> <i class="fa fa-pencil"></i> Editar</a>
                            <a href="/modules" class="btn btn-white btn-xs"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        </div>
                        <h2>Modulo: {{$record->name}}</h2>
                    </div>
                    @if($record->created_at->diffInMinutes() < 2)
                    <dl class="dl-horizontal">
                        <span class="label label-primary pull-right">Nuevo</span>
                    </dl>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <dl class="dl-horizontal">
                        <dt>Asignatura:</dt> <dd>{{$record->subject->name}}</dd>
                        <dt>Creado por:</dt> <dd>{{$record->user->name}}</dd>
                    </dl>
                </div>
                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal" >
                        <dt>Creación:</dt> <dd>{{ $record->created_at->format('d-m-Y') }}</dd>
                        <dt>Actualización:</dt> <dd>{{ $record->updated_at->format('d-m-Y') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="row m-t-sm">
                <div class="col-lg-12">
                    <div class="panel blank-panel">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">Comentarios</a></li>
                                    <li class=""><a href="#tab-2" data-toggle="tab" onclick="minificarTablas()">Elementos relacionados</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    @include('layouts._conversations')
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>Enlaces</h5>
                                            <div class="ibox-tools">
                                                <a href="/links/create/{{ $record->id }}" class="btn btn-primary btn-xs"> <i class="fa fa-check"></i> Agregar enlace</a>
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            @include('layouts._spinner_code')
                                            <table class="table table-striped table-bordered table-hover dataTables-related" >
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Enlace</th>
                                                        <th>Fecha de creación</th>
                                                        <th>Creado por</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($record->links as $element)
                                                    <tr class="gradeX">
                                                        <td>{{ $element->name }}</td>
                                                        <td><a href="{{ $element->link }}" target="_blank">{{ $element->link }}</a></td>
                                                        <td>{{ $element->created_at }}</td>
                                                        <td>{{ $element->user->name }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Enlace</th>
                                                        <th>Fecha de creación</th>
                                                        <th>Creado por</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    @include('layouts._table_related', ['title' => 'Articulos', 'elements' => $record->articles, 'nroTable' => '1', 'url' => "/articles/create/$record->id", 'new' => 'artículo', 'button' => true])
                                    @include('layouts._table_related', ['title' => 'Foro', 'elements' => $record->forums, 'nroTable' => '2', 'url' => "/forums/create/$record->id", 'new' => 'foro', 'button' => true])
                                    @include('layouts._table_related', ['title' => 'Muro', 'elements' => $record->walls, 'nroTable' => '3', 'url' => "/walls/create/$record->id", 'new' => 'muro', 'button' => true])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    $(function () {
        $('#side-menu li.active').removeClass('active');
        var url = jQuery(location).attr('href').split('/')[3];
        $("#side-menu [href='/" + url +"']").parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().addClass('active');
    });
    
    function pulsar(textarea, e, tipoComentario, idParent) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            comentario = $(textarea).val();
            if (comentario !== '') {
                $(textarea).val('');
                agregarComentario('modules', comentario, tipoComentario, idParent);
            }
        }
    }
    
    function irSeccion() {
        window.location.href = $('#secciones').val();
    }
</script>
@include('layouts._script_spinner_code')
@endsection