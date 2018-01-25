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
                <strong>Crear grupo</strong>
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
            <a onclick="document.getElementById('form-create').submit(); " class="btn btn-primary btn-sm">
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
                <h5>Registra la información <small>Grupos.</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a href="/groups">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="post" action="/groups/store" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre del grupo</label>
                        <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10"><textarea name="description" class="form-control"></textarea> </div>
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
                                                <tr id="{{$to->id}}" name="{{$to->id}}">
                                                    <!-- <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td> -->
                                                    <td>{{ $to->name }}</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td>{{ $to->email }}</td>
                                                    <td><a class="btn btn-primary btn-xs" onclick="moverUsuario({{$to->id}}, 1)"><i class="fa fa-plus"> </i> Agregar</a></td>
                                                </tr>
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
@elseif($typeView == 'list')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        @foreach ($records as $rec)
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    @if($rec->created_at->diffInMinutes() < 2)
                        <span class="label label-primary pull-right">Nuevo</span>
                    @endif
                    <h5 class="cortar"><a href="/groups/show/{{ $rec->id }}" >
                            {{ $rec->name }}
                        </a></h5>
                </div>
                <div class="ibox-content">
                    <div class="team-members">
                        @foreach ($rec->users as $groupUser)
                        <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a'. $groupUser->pivot->user_id .'.jpg')}}"> </a>
                        @endforeach
                    </div>
                    <h4>Descripción del grupo:</h4>
                    <p>
                        {{ $rec->description }}
                    </p>
                    <div>
                        <span>Progreso del curso:</span>
                        <div class="stat-percent">48%</div>
                        <div class="progress progress-mini">
                            <div style="width: 48%;" class="progress-bar"></div>
                        </div>
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
        @endforeach
    </div>
</div>

@elseif($typeView == 'view')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        <a href="/groups" class="btn btn-white btn-xs pull-right"> <i class="fa fa-chevron-left"></i> Regresar</a>
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
                        <dt>Número de participantes:</dt> <dd>  {{count($record->users)}}</dd>
                        <dt>Entidad:</dt> <dd><a href="#" class="text-navy"> UAEH</a> </dd>
                    </dl>
                </div>
                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal" >
                        <dt>Inicia:</dt> <dd>
                        <dt>Termina:</dt> <dd>
                        <dt>Docentes:</dt>
                        <dd class="project-people">
                            @foreach ($record->users as $groupUser)
                            <a href="#"><img alt="image" class="img-circle" src="{{ asset('inspinia/img/a'. $groupUser->pivot->user_id .'.jpg')}}"> </a>
                            @endforeach
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Completado:</dt>
                        <dd>
                            <div class="progress progress-striped active m-b-sm">
                                <div style="width: 2%;" class="progress-bar"></div>
                            </div>
                            <small>El ciclo tiene <strong>0%</strong> completado.</small>
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
                                    <li class=""><a href="#tab-2" data-toggle="tab">Elementos relacionados</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <div class="feed-activity-list">
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{ asset('inspinia/img/a2.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">2h ago</small>
                                                <strong>Mark Johnson</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                                                <div class="well">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                    Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                </div>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{ asset('inspinia/img/a3.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">2h ago</small>
                                                <strong>Janet Rosowski</strong> add 1 photo on <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">2 days ago at 8:30am</small>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{ asset('inspinia/img/a4.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right text-navy">5h ago</small>
                                                <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                                <div class="actions">
                                                    <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                                    <a class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{ asset('inspinia/img/a5.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">2h ago</small>
                                                <strong>Kim Smith</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                <small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
                                                <div class="well">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                    Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                </div>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{ asset('inspinia/img/profile.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">23h ago</small>
                                                <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">46h ago</small>
                                                <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
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
</script>
@endsection