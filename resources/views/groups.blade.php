@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Grupos</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Grupos de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Grupos de la organización
            </li>
                <li class="active">
                @if($record->exists)
                    <strong>Editar grupo</strong>
                @else
                    <strong>Crear grupo</strong>
                @endif
                </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/groups/create" class="btn btn-primary btn-sm">Agregar Grupo</a>
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
                <h5>Registra la información <small>Grupos.</small></h5>
                <div class="ibox-tools">
                    <a href="/groups">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                @if($record->exists)
                <form method="post" action="/groups/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/groups/store" id="form-create" class="form-horizontal">
                @endif
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre del grupo</label>
                        <div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{ $record->name or old('name') }}" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10"><textarea name="description" class="form-control" required>{{ $record->description or old('descripcion') }}</textarea> </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <!-- Lista de usuarios -->
                    <div class="input">
                        <input type="text" placeholder="Buscar usuario " title="Escriba un nombre" id="buscar_usuario" onkeyup="buscarUsuario()" class="input form-control">
                    </div>
                    <div class="clients-list">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1" onclick="habilitarDeshabilitarBuscador('tab-1')"><i class="fa fa-user"></i> Usuarios</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2" onclick="habilitarDeshabilitarBuscador('tab-2')"><i class="fa fa-plus"></i> Agregados</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="full-height-scroll">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="tabla_usuarios">
                                            <tbody>
                                                @foreach ($to_related as $to)
                                                    @php($encontrado = false)
                                                    @foreach ($record->users as $groupUser)
                                                        @if($groupUser->id == $to->id)
                                                            @php($encontrado = true)
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if(!$encontrado)
                                                    <tr id="{{$to->id}}" name="{{$to->id}}">
                                                        <!-- <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td> -->
                                                        <td>{{ $to->name }}</td>
                                                        <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                        <td>{{ $to->email }}</td>
                                                        <td><a class="btn btn-primary btn-xs" onclick="moverUsuario({{$to->id}}, 1)"><i class="fa fa-plus"> </i> Agregar</a></td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="tab-2" class="tab-pane">
                                <div class="full-height-scroll">
                                    <div class="table-responsive">
                                        <table id="tabla_agregados" class="table table-striped table-hover">
                                            <tbody>
                                                @php($listUser = [])
                                                @foreach ($to_related as $to)
                                                    @php($encontrado = false)
                                                    @foreach ($record->users as $groupUser)
                                                        @if($groupUser->id == $to->id)
                                                            @php($encontrado = true)
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if($encontrado)
                                                        @php($listUser[] = $to->id)
                                                        <tr id="{{$to->id}}" name="{{$to->id}}">
                                                            <td>{{ $to->name }}</td>
                                                            <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                            <td>{{ $to->email }}</td>
                                                            <td><a class="btn btn-default btn-xs" onclick="moverUsuario({{$to->id}}, 2)"><i class="fa fa-minus"> </i> Remover</a></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <input name="users" id="users" type="hidden">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    lista_usuarios = [];
    $(function (){
        trUser = '';
        @foreach ($listUser as $userId)
            lista_usuarios.push({{ $userId }});
        @endforeach
        $('#users').val(lista_usuarios);
    });
    
    function moverUsuario(idUsuario, accion) {
        trUser = $("#" + idUsuario)[0];
        if (accion === 1) { 
            lista_usuarios.push(idUsuario);
            $("#"+idUsuario+" td:eq(3)").html('<a class="btn btn-default btn-xs" onclick="moverUsuario(' + idUsuario + ', 2)"><i class="fa fa-minus"> </i> Remover</a>');
            $("#tabla_usuarios tr#" + idUsuario).remove();
            $("#tabla_agregados").append(trUser);
        } else {
            $("#"+idUsuario+" td:eq(3)").html('<a class="btn btn-primary btn-xs" onclick="moverUsuario(' + idUsuario + ', 1)"><i class="fa fa-plus"> </i> Agregar</a>');
            $("#tabla_agregados tr#" + idUsuario).remove();
            $("#tabla_usuarios").append(trUser);
            lista_usuarios = $.grep(lista_usuarios, function(value) {
                return value != idUsuario;
            });
        }
        $('#users').val(lista_usuarios);
        if ($("#buscar_usuario").val() !== '') {
            $("#buscar_usuario").val('');
            buscarUsuario();
        }
    }
    
    function habilitarDeshabilitarBuscador(tab) {
        if (tab === 'tab-1') {
            $("#buscar_usuario").prop('disabled', false);
        } else {
            $("#buscar_usuario").prop('disabled', true);
        }
    }
    
    function buscarUsuario() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("buscar_usuario");
        filter = input.value.toUpperCase();
        table = document.getElementById("tabla_usuarios");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > - 1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@elseif($typeView == 'list')

<div class="wrapper wrapper-content animated fadeInRight">
    @foreach ($records as $key => $rec)
        @if($key%3 == 0)
            @if(!$loop->first)
                </div>
            @endif
        <div class="row row-eq-height">
        @endif
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    @if($rec->created_at->diffInMinutes() < 2)
                        <span class="label label-primary pull-right">Nuevo</span>
                    @endif
                    <h5 class="cortar"><a href="/groups/show/{{ $rec->id }}" >{{ $rec->name }}</a></h5>
                </div>
                <div class="ibox-content">
                    @include('layouts._spinner_code')
                    <div class="team-members">
                        @foreach ($rec->users as $groupUser)
                            @if($groupUser->type == 'master')
                            <a href="#"><img title="{{ $groupUser->name }}" alt="member" class="img-circle" src="{{ asset('uploads/avatars/'. $groupUser->avatar) }}"> </a>
                            @endif
                        @endforeach
                    </div>
                    <div>
                    <h4>Descripción del grupo:</h4>
                    <p>
                        {{ $rec->description }}
                    </p>
                    </div>
                    <div class="row  m-t-sm">
                        <div class="col-sm-4">
                            <div class="font-bold">Miembros</div>
                            {{ count($rec->users) }}
                        </div>
                        <div class="col-sm-4">
                            <div class="font-bold">Calificación</div>
                            82
                        </div>
                        <div class="col-sm-4 text-right">
                            <div class="font-bold">ROI</div>
                            $200,913 <i class="fa fa-level-up text-navy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($loop->last)
        </div>
        @endif
        @endforeach
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
                            <a href="/groups/edit/{{ $record->id }}" class="btn btn-white btn-xs"> <i class="fa fa-pencil"></i> Editar</a>
                            <a href="/groups" class="btn btn-white btn-xs"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        </div>
                        <h2>Grupo: {{$record->name}}</h2>
                    </div>
                    @if($record->created_at->diffInMinutes() < 2)
                    <dl class="dl-horizontal">
                        <span class="label label-primary pull-right">Nuevo</span>
                    </dl>
                    @endif
                    <h4>Descripción del grupo:</h4>
                    <p>
                        {{ $record->description }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <dl class="dl-horizontal">
                        <dt>Creado por:</dt> <dd>{{$record->user->name}}</dd>
                        <dt>Nro. de participantes:</dt> <dd>  {{count($record->users)}}</dd>
                        <dt></dt> <dd></dd>
                    </dl>
                </div>
                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal" >
                        <dt>Creación:</dt> <dd>{{ $record->created_at->format('d-m-Y') }}</dd>
                        <dt>Actualización:</dt> <dd>{{ $record->updated_at->format('d-m-Y') }}</dd>
                        <dt>Participantes:</dt>
                        <dd class="project-people">
                            @foreach ($record->users as $groupUser)
                            <a href="#"><img title="{{ $groupUser->name }}" alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $groupUser->avatar) }}"> </a>
                            @endforeach
                        </dd>
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
                                    <li class=""><a href="#tab-2" data-toggle="tab">Miembros</a></li>
                                    <li class=""><a href="#tab-3" data-toggle="tab" onclick="minificarTablas()">Elementos relacionados</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    @include('layouts._conversations')
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th></th>
                                                <th>Correo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($record->users as $groupUser)
                                            <tr>
                                                <td> {{ $groupUser->name }} </td>
                                                <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                <td> {{ $groupUser->email }} </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab-3">
                                    @include('layouts._table_related', ['title' => 'Asignaturas', 'elements' => $record->subjects, 'nroTable' => '1', 'url' => "", 'new' => 'asignatura', 'button' => false])
                                    @include('layouts._table_related', ['title' => 'Tareas asignadas', 'elements' => $record->tasks, 'nroTable' => '2', 'url' => "", 'new' => 'tarea', 'button' => false])
                                    @include('layouts._table_related', ['title' => 'Examenes asignados', 'elements' => $record->exams, 'nroTable' => '3', 'url' => "", 'new' => 'examen', 'button' => false])
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
    $('.ibox').children('.ibox-content').toggleClass('sk-loading');
    $(function (){
        $('textarea').prop('maxlength', 250);
    });

    function pulsar(textarea, e, tipoComentario, idParent) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            comentario = $(textarea).val();
            if (comentario !== '') {
                $(textarea).val('');
                agregarComentario('groups', comentario, tipoComentario, idParent);
            }
        }
    }
</script>
@endsection