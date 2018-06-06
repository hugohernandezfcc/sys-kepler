@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Enlaces</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Enlaces de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Enlaces de la organización
            </li>
            <li class="active">
                @if($record->exists)
                    <strong>Editar enlace</strong>
                @else
                    <strong>Crear enlace</strong>
                @endif
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/links/create" class="btn btn-primary btn-sm">Agregar enlace</a>
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
                <h5>Registra la información <small>enlace.</small></h5>
                <div class="ibox-tools">
                    <a href="/links">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                @if($record->exists)
                <form method="post" action="/links/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/links/store" id="form-create" class="form-horizontal">
                @endif
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Titulo del enlace</label>
                        <div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{ $record->name or old('name') }}" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Enlace</label>
                        <div class="col-sm-10"><input type="url" name="link" class="form-control" value="{{ $record->link or old('link') }}" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10"><textarea name="description" class="form-control" required>{{ $record->description or old('descripcion') }}</textarea> </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Modulo</label>
                        <div class="col-sm-10">
                            @if($module->exists)
                                <input type="hidden" name="module_id" value="{{ $module->id }}">
                                <select class="form-control" id="module_id" disabled>

                                    @foreach ($to_related as $to)
                                        @if($module->id == $to->id)
                                            <option value="{{$to->id}}" selected>{{$to->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control" name="module_id" id="module_id">

                                    @foreach ($to_related as $to)
                                        @if($record->module_id == $to->id)
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
                    <h5>Lista de enlaces</h5>
                </div>
                <div class="ibox-content">
                    @include('layouts._spinner_code')

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Titulo</th>
                                    <th>Enlace</th>
                                    <th>Descripción</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td> 
                                        <a href="/links/show/{{ $rec->id }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> 
                                    </td>
                                    <td>{{ $rec->name }}</td>
                                    <td><a href="{{ $rec->link }}" target="_blank">{{ $rec->link }}</a></td>
                                    <td>{{ $rec->description }}</td>
                                    <td>{{ $rec->created_at }}</td>
                                    <td>{{ $rec->user->name }}</td>
                                </tr>

                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th> - </th>
                                    <th>Titulo</th>
                                    <th>Enlace</th>
                                    <th>Descripción</th>
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
                        <a href="/links" class="btn btn-white btn-xs pull-right"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        <a href="/links/edit/{{ $record->id }}" class="btn btn-white btn-xs pull-right"> <i class="fa fa-pencil"></i> Editar</a>
                        <h2>Titulo: {{$record->name}}</h2>
                    </div>
                    @if($record->created_at->diffInMinutes() < 2)
                    <dl class="dl-horizontal">
                        <span class="label label-primary pull-right">Nuevo</span>
                    </dl>
                    @endif
                    <h4>Descripción del enlace:</h4>
                    <p>
                        {{ $record->description }}
                    </p>
                    <h4>Enlace:</h4>
                    <p>
                        <a href="{{ $record->link }}" target="_blank">{{ $record->link }}</a>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Modulo:</dt> <dd>{{$record->module->name}}</dd>
                        <dt>Creado por:</dt> <dd>{{$record->user->name}}</dd>
                    </dl>
                </div>
                <div class="col-lg-6" id="cluster_info">
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
        $("#side-menu [href='/" + url +"']").parent().parent().parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().addClass('active');
    });
    
    function pulsar(textarea, e, tipoComentario, idParent) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            comentario = $(textarea).val();
            if (comentario !== '') {
                $(textarea).val('');
                agregarComentario('links', comentario, tipoComentario, idParent);
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
@include('layouts._script_spinner_code')
@endsection