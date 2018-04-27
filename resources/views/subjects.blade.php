@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Asignaturas</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Asignaturas de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Asignaturas de la organización
            </li>
            <li class="active">
                @if($record->exists)
                    <strong>Editar asignatura</strong>
                @else
                    <strong>Crear asignatura</strong>
                @endif
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/subjects/create" class="btn btn-primary btn-sm">Agregar asignatura</a>
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
                <h5>Registra la información <small>Asignatura.</small></h5>
                <div class="ibox-tools">
                    <a href="/subjects">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @if($record->exists)
                <form method="post" action="/subjects/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/subjects/store" id="form-create" class="form-horizontal">
                @endif
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre de la asignatura</label>
                        <div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{ $record->name or old('name') }}" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Área</label>
                        <div class="col-sm-10">
                            @if($area->exists)
                                <input type="hidden" name="area_id" value="{{ $area->id }}">
                                <select class="form-control" id="area_id" disabled>
                                    @foreach ($to_related as $to)
                                        @if($area->id == $to->id)
                                            <option value="{{$to->id}}" selected>{{$to->name}}</option>
                                            @break
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control" name="area_id" id="area_id">
                                    @foreach ($to_related as $to)
                                        @if($record->area_id == $to->id)
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

                    <!-- Lista de grupos -->
                    <div class="input">
                        <input type="text" placeholder="Buscar grupo " title="Escriba el nombre de un grupo" id="buscar_grupo" onkeyup="buscarGrupo()" class="input form-control">
                    </div>
                    <div class="clients-list">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1" onclick="habilitarDeshabilitarBuscador('tab-1')"><i class="fa fa-group"></i> Grupos</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2" onclick="habilitarDeshabilitarBuscador('tab-2')"><i class="fa fa-plus"></i> Agregados</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="full-height-scroll">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="tabla_grupos">
                                            <tbody>
                                                @foreach ($groups as $group)
                                                    @php
                                                    $encontrado = false;
                                                    foreach ($record->groups as $groupSubject) {
                                                        if($groupSubject->id == $group->id) {
                                                            $encontrado = true;
                                                            break;
                                                        }
                                                    }
                                                    @endphp
                                                    @if(!$encontrado)
                                                    <tr id="{{$group->id}}" name="{{$group->id}}">
                                                        <td>{{ $group->name }}</td>
                                                        <td><a class="btn btn-primary btn-xs" onclick="moverGrupo({{$group->id}}, 1)"><i class="fa fa-plus"> </i> Agregar</a></td>
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
                                            @php($listGroup = [])
                                                @foreach ($groups as $to)
                                                    @php($encontrado = false)
                                                    @foreach ($record->groups as $groupSubject)
                                                        @if($groupSubject->id == $to->id)
                                                            @php($encontrado = true)
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if($encontrado)
                                                        @php($listGroup[] = $to->id)
                                                        <tr id="{{$to->id}}" name="{{$to->id}}">
                                                            <td>{{ $to->name }}</td>
                                                            <td><a class="btn btn-default btn-xs" onclick="moverGrupo({{$to->id}}, 2)"><i class="fa fa-minus"> </i> Remover</a></td>
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
                        <input name="groups" id="groups" type="hidden">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    lista_grupos = [];
    $(function (){
        trUser = '';
        @foreach ($listGroup as $groupId)
            lista_grupos.push({{ $groupId }});
        @endforeach
        $('#groups').val(lista_grupos);
    });
    
    function moverGrupo(idGrupo, accion) {
        trUser = $("#" + idGrupo)[0];
        if (accion === 1) {
            lista_grupos.push(idGrupo);
            $("#"+idGrupo+" td:eq(1)").html('<a class="btn btn-default btn-xs" onclick="moverGrupo(' + idGrupo + ', 2)"><i class="fa fa-minus"> </i> Remover</a>');
            $("#tabla_grupos tr#" + idGrupo).remove();
            $("#tabla_agregados").append(trUser);
        } else {
            $("#"+idGrupo+" td:eq(1)").html('<a class="btn btn-primary btn-xs" onclick="moverGrupo(' + idGrupo + ', 1)"><i class="fa fa-plus"> </i> Agregar</a>');
            $("#tabla_agregados tr#" + idGrupo).remove();
            $("#tabla_grupos").append(trUser);
            lista_grupos = $.grep(lista_grupos, function(value) {
                return value != idGrupo;
            });
        }
        $('#groups').val(lista_grupos);
        if ($("#buscar_grupo").val() !== '') {
            $("#buscar_grupo").val('');
            buscarGrupo();
        }
    }
    
    function habilitarDeshabilitarBuscador(tab) {
        if (tab === 'tab-1') {
            $("#buscar_grupo").prop('disabled', false);
        } else {
            $("#buscar_grupo").val('');
            buscarGrupo();
            $("#buscar_grupo").prop('disabled', true);
        }
    }
    
    function buscarGrupo() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("buscar_grupo");
        filter = input.value.toUpperCase();
        table = document.getElementById("tabla_grupos");
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
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de asignaturas</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Nombre de asignatura</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td> 
                                        <a href="/subjects/show/{{ $rec->id }}" class="btn btn-primary btn-xs">
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
                                    <th>Nombre de asignatura</th>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        <a href="/subjects" class="btn btn-white btn-xs pull-right"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        <a href="/subjects/edit/{{ $record->id }}" class="btn btn-white btn-xs pull-right"> <i class="fa fa-pencil"></i> Editar</a>
                        <h2>Asignatura: {{$record->name}}</h2>
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
                        <dt>Area:</dt> <dd>{{ $record->area->name }}</dd>
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
                                    <div class="social-feed-separated">
                                        @foreach ($comments as $conversations)
                                        <div class="social-avatar">
                                            <a href=""><img alt="image" src="{{ asset('uploads/avatars/'. $conversations['Question']->user->avatar) }}"></a>
                                        </div>
                                        <div class="social-feed-box">
                                            <div class="social-avatar">
                                                <a href="#">{{ $conversations['Question']->user->name }}</a><small class="text-muted"> - {{ $conversations['Question']->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="social-body">
                                                <p>{{ $conversations['Question']->name }}</p><br>
                                                <div class="btn-group">
                                                    <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $conversations['Question']->id }})"><i class="fa fa-comments"></i> Comentar</a>
                                                </div>
                                            </div>
                                            <div class="social-footer">
                                                @if (count($conversations['Answer'][0]) > 0)
                                                @foreach ($conversations['Answer'][0] as $itemConversation)
                                                <div class="social-comment">
                                                    <a href="" class="pull-left"><img alt="image" src="{{ asset('uploads/avatars/'. $itemConversation->user->avatar) }}"></a>
                                                    <div class="media-body">
                                                        <a href="#">{{ $itemConversation->user->name }}</a>  {{ $itemConversation->name }}<br>
                                                        <div class="btn-group">
                                                            <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $itemConversation->id }})"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">{{ $itemConversation->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>

                                                    @if (count($itemConversation['AnswerToAnswer']) > 0)
                                                    @foreach ($itemConversation['AnswerToAnswer'] as $itemAnswer)
                                                    <div class="social-comment">
                                                        <a href="" class="pull-left"><img alt="image" src="{{ asset('uploads/avatars/'. $itemAnswer->user->avatar) }}"></a>
                                                        <div class="media-body">
                                                            <a href="#">{{ $itemAnswer->user->name }}</a> {{ $itemAnswer->name }}<br><small class="text-muted">{{ $itemAnswer->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif

                                                    <div class="social-comment hidden" id="comentario{{ $itemConversation->id }}">
                                                        <a href="" class="pull-left"> <img alt="image" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                                                        <div class="media-body">
                                                            <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer to Answer', {{ $itemConversation->id }})" placeholder="Escribe un comentario..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                @endforeach
                                                @endif
                                                <div class="social-comment hidden" id="comentario{{ $conversations['Question']->id }}">
                                                    <a href="" class="pull-left"><img alt="image" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
                                                    <div class="media-body">
                                                        <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer', {{ $conversations['Question']->id }})" placeholder="Escribe un comentario..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>

                                        @endforeach 

                                        <div id='ultimo_comentario'>
                                            <div class="social-avatar">
                                                <a href=""><img alt="image" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
                                            </div>
                                            <div class="media-body">
                                                <textarea class="form-control" onkeypress="pulsar(this, event, 'Question', null)" placeholder="Escribe un comentario..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-2">
                                    @include('layouts._table_related', ['title' => 'Grupos', 'elements' => $record->groups, 'nroTable' => '1', 'url' => "", 'new' => 'tarea', 'button' => false])
                                    @include('layouts._table_related', ['title' => 'Tareas', 'elements' => $record->tasks, 'nroTable' => '2', 'url' => "/task/create/$record->id", 'new' => 'tarea', 'button' => true])
                                    @include('layouts._table_related', ['title' => 'Modulos', 'elements' => $record->modules, 'nroTable' => '3', 'url' => "/modules/create/$record->id", 'new' => 'modulo', 'button' => true])
                                    @include('layouts._table_related', ['title' => 'Examenes', 'elements' => $record->exams, 'nroTable' => '4', 'url' => "/test/create/$record->id", 'new' => 'examen', 'button' => true])
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
                agregarComentario('subjects', comentario, tipoComentario, idParent);
            }
        }
    }
    
    function agregarComentario(tabla, comentario, tipoComentario, idParent) {
        idRecord = $('#idRecord').val();
        var imagenUsuario = '';
        imagenUsuario = '{{ asset("uploads/avatars/". Auth::user()->avatar) }}';
        $.ajax({
            url: "/conversations/store",
            data: { 
                "table":tabla,
                "id_record":idRecord,
                "comentario":comentario,
                "type":tipoComentario,
                "parent":idParent,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.type === 'Question') {
                    var answer = "\'Answer\'";
                    var html = '<div class="social-avatar"><a href=""><img alt="image" src="'+imagenUsuario+'"></a></div>\n\
                    <div class="social-feed-box"><div class="social-avatar"><a href="#">'+result.user_name+'</a><small class="text-muted"> - '+result.tiempo+'</small></div>\n\
                    <div class="social-body"><p>'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div></div>';
                    $('#ultimo_comentario').before(html);
                } else if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a><div class="media-body"><a href="#">'+result.user_name+'</a>  '+  result.name+'<br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">'+result.tiempo+'</small></div></div>\n\
                    <div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"> <img alt="image" src="'+imagenUsuario+'"> </a><div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div>';
                    $('#comentario'+result.parent).before(html);
                } else {
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a><div class="media-body"><a href="#">'+result.user_name+'</a>  '+  result.name+'<br><small class="text-muted">'+result.tiempo+'</small></div></div>';
                    $('#comentario'+result.parent).before(html);
                }
            },
            error: function () {
               //alert("fallo");
            }
            
        });
    }
    
    function habilitarComentario(idCampo) {
        if ($('#comentario'+idCampo).hasClass("hidden")) {
            $('#comentario'+idCampo).removeClass("hidden");
        }
        $('#comentario'+idCampo+' textarea').focus();    
    }
</script>
@endsection