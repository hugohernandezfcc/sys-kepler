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
                <strong>Crear asignatura</strong>
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
            <a onclick="document.getElementById('form-create').submit();" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </a>
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
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a href="/subjects">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="post" action="/subjects/store" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre de la asignatura</label>

                        <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Área</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="area_id" id="area_id">

                                @foreach ($to_related as $to)
                                <option value="{{$to->id}}">{{$to->name}}</option>
                                @endforeach
                            </select>
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
                    <h5>Lista de asignaturas</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
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
                        <h2>Asignatura: {{$record->name}}</h2>
                    </div>
                    @if($record->created_at->diffInMinutes() < 2)
                    <dl class="dl-horizontal">
                        <span class="label label-primary pull-right">Nuevo</span>
                    </dl>
                    @endif
                    <h4>Descripción de la asignatura:</h4>
                    <p>
                        {{ $record->description }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <dl class="dl-horizontal">

                        <dt>Creado por:</dt> <dd>{{$record->user->name}}</dd>
                        <dt>Entidad:</dt> <dd><a href="#" class="text-navy"> UAEH</a> </dd>
                    </dl>
                </div>
                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal" >
                        <dt>Descripción:</dt> <dd>{{$record->description}}</dd>
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
                                    <li class=""><a href="#tab-2" data-toggle="tab">Elementos relacionados</a></li>
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

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Title</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Comments</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
                                                </td>
                                                <td>
                                                    Create project in webapp
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
                                                </td>
                                                <td>
                                                    Various versions
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                </td>
                                                <td>
                                                    There are many variations
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
                                                </td>
                                                <td>
                                                    Latin words
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Latin words, combined with a handful of model sentence structures
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
                                                </td>
                                                <td>
                                                    The generated Lorem
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                </td>
                                                <td>
                                                    The first line
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
                                                </td>
                                                <td>
                                                    The standard chunk
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
                                                </td>
                                                <td>
                                                    Lorem Ipsum is that
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                </td>
                                                <td>
                                                    Contrary to popular
                                                </td>
                                                <td>
                                                    12.07.2014 10:10:1
                                                </td>
                                                <td>
                                                    14.07.2014 10:16:36
                                                </td>
                                                <td>
                                                    <p class="small">
                                                        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
    lista_usuarios = [];
    trUser = '';
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
            lista_usuarios = jQuery.grep(lista_usuarios, function(value) {
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
                    <div class="social-body"><p>'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" src="inspinia/img/a3.jpg"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div></div>';
                    $('#ultimo_comentario').before(html);
                } else if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a><div class="media-body"><a href="#">'+result.user_name+'</a>  '+  result.name+'<br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">'+result.tiempo+'</small></div></div>\n\
                    <div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"> <img alt="image" src="inspinia/img/a8.jpg"> </a><div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div>';
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