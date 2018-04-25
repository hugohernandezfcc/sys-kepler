@extends('layouts.app')

@section('content')
@if($typeView != 'view' AND $typeView != 'question')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Foro</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Foro de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Foro de la organización
            </li>
            <li class="active">
                @if($record->exists)
                    <strong>Editar foro</strong>
                @else
                    <strong>Crear foro</strong>
                @endif
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/forums/create" class="btn btn-primary btn-sm">Agregar foro</a>
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
@endif



@if($typeView == 'form')
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Registra la información <small>foro.</small></h5>
                <div class="ibox-tools">
                    <a href="/forums">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @if($record->exists)
                <form method="post" action="/forums/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/forums/store" id="form-create" class="form-horizontal">
                @endif
                    {{ csrf_field() }}
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
                    <h5>Lista de foro</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Ruta</th>
                                    <th>Descripción</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td> 
                                        <a href="/forums/show/{{ $rec->name }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> 
                                    </td>
                                    <td>{{ asset('/forums/show/'.$rec->name) }}</td>
                                    <td>{{ $rec->description }}</td>
                                    <td>{{ $rec->created_at }}</td>
                                    <td>{{ $rec->user->name }}</td>
                                </tr>

                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th> - </th>
                                    <th>Ruta</th>
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
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            <form id="form-delete" method="post" action="/forums/{{ $record->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="form-group">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn-xs pull-right" id="submitBtn" data-toggle="modal" data-target="#confirmDelete"> <i class="fa fa-remove"></i> Eliminar</button>
                        <a href="#redactarPregunta" id="toggle" data-toggle="modal" class="btn btn-primary btn-xs">Nueva pregunta</a>
                    </div>
                </div>
            </form>
            <div class="modal fade" id="redactarPregunta">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Formular pregunta</h4>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="/questionsforums/store" id="form-create" class="form-horizontal">
                                {{ csrf_field() }}
                                <input type="hidden" id="idRecord" name="forumId" value="{{ $record->id }}">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Titulo</label>
                                    <div class="col-sm-10"><input type="text" name="name" class="form-control" required></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripción</label>
                                    <div class="col-sm-10"><textarea name="body" class="form-control" required></textarea> </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" form="form-create" class="btn btn-primary btn-sm">Publicar</button>
                            <button type="button" class="btn btn-default" id="cerrarPost" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            @include('layouts._modal_confirmation_delete', ['name' => 'foro'])
            <br>
        </div>
    </div>

    @foreach($questionsForums->sortByDesc('cantVotes') as $question)
        @php
            $cantComments = 0;
            $lastComment = null;
            if(count($comments) > 0) {
                $aux = $question->itemconversation->where('conversation', '=', $comments[0]['Question']->conversation)->where('name', '=', $question->id)->first();
                $cantComments = $question->itemconversation->where('parent', '=', $aux->id)->count();
                $lastComment = $question->itemconversation->where('parent', '=', $aux->id)->orderBy('updated_at', 'desc')->first();
            }
        @endphp
        <div class="vote-item">
            <div class="row">
                <div class="col-md-10">
                    <div class="vote-actions">
                        @if($question->created_by === Auth::user()->id)
                        <button class="btn btn-xs btn-link" disabled id="Positivo{{$question->id}}" title='No puedes votar por tu pregunta'>
                            <i class="fa fa-chevron-up"> </i>
                        </button>
                        @elseif($question->votes->where('type', '=', 'Positivo')->firstwhere('by', '=', Auth::user()->id) === null)
                        <button onclick="vote('Positivo', {{$question->id}})" class="btn btn-xs btn-link" id="Positivo{{$question->id}}" title='Esta pregunta es útil'>
                            <i class="fa fa-chevron-up"> </i>
                        </button>
                        @else
                        <button onclick="vote('Positivo', {{$question->id}})" class="btn btn-xs btn-link" disabled id="Positivo{{$question->id}}" title='Ya has votado positivamente por esta pregunta'>
                            <i class="fa fa-chevron-up"> </i>
                        </button>
                        @endif
                        <div><span id="votes{{$question->id}}">{{$question->cantVotes}}</span></div>
                        @if($question->created_by === Auth::user()->id)
                        <button class="btn btn-xs btn-link" disabled id="Negativo{{$question->id}}" title='No puedes votar por tu pregunta'>
                            <i class="fa fa-chevron-down"> </i>
                        </button>
                        @elseif($question->votes->where('type', '=', 'Negativo')->firstwhere('by', '=', Auth::user()->id) === null)
                        <button onclick="vote('Negativo', {{$question->id}})" class="btn btn-xs btn-link" id="Negativo{{$question->id}}" title='Esta pregunta no es útil'>
                            <i class="fa fa-chevron-down"> </i>
                        </button>
                        @else
                        <button onclick="vote('Negativo', {{$question->id}})" class="btn btn-xs btn-link" disabled id="Negativo{{$question->id}}" title='Ya has votado negativamente por esta pregunta'>
                            <i class="fa fa-chevron-down"> </i>
                        </button>
                        @endif
                    </div>
                    <a href="/forums/{{$record->name}}/question/{{$question->id}}" class="vote-title">
                        {{$question->name}}
                    </a>
                    <div class="vote-info">
                        <i class="fa fa-comments-o"></i> <a href="#">Respuestas ({{ $cantComments }})</a>
                        @if($lastComment !== null)
                            <i class="fa fa-clock-o"></i> <a href="#">{{ $lastComment->created_at->diffForHumans() }}</a>
                            <i class="fa fa-user"></i> <a href="#">{{ $lastComment->user->name }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@elseif($typeView == 'question')
<input type="hidden" id="idRecord" value="{{ $record->id }}">
<input type="hidden" id="idQuestion" value="{{ $question->id }}">
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-2">
                    @php
                        $votes = 0;
                        $votes = $question->votes->where('type', '=', 'Positivo')->count() - $question->votes->where('type', '=', 'Negativo')->count();
                    @endphp
                    <div class="vote-actions">
                        @if($question->created_by === Auth::user()->id)
                        <button class="btn btn-xs btn-link" disabled id="Positivo{{$question->id}}" title='No puedes votar por tu pregunta'>
                            <i class="fa fa-chevron-up"> </i>
                        </button>
                        @elseif($question->votes->where('type', '=', 'Positivo')->firstwhere('by', '=', Auth::user()->id) === null)
                        <button onclick="vote('Positivo', {{$question->id}})" class="btn btn-xs btn-link" id="Positivo{{$question->id}}" title='Esta pregunta es útil'>
                            <i class="fa fa-chevron-up"> </i>
                        </button>
                        @else
                        <button onclick="vote('Positivo', {{$question->id}})" class="btn btn-xs btn-link" disabled id="Positivo{{$question->id}}" title='Ya has votado positivamente por esta pregunta'>
                            <i class="fa fa-chevron-up"> </i>
                        </button>
                        @endif
                        <div><span id="votes{{$question->id}}">{{$votes}}</span></div>
                        @if($question->created_by === Auth::user()->id)
                        <button class="btn btn-xs btn-link" disabled id="Negativo{{$question->id}}" title='No puedes votar por tu pregunta'>
                            <i class="fa fa-chevron-down"> </i>
                        </button>
                        @elseif($question->votes->where('type', '=', 'Negativo')->firstwhere('by', '=', Auth::user()->id) === null)
                        <button onclick="vote('Negativo', {{$question->id}})" class="btn btn-xs btn-link" id="Negativo{{$question->id}}" title='Esta pregunta no es útil'>
                            <i class="fa fa-chevron-down"> </i>
                        </button>
                        @else
                        <button onclick="vote('Negativo', {{$question->id}})" class="btn btn-xs btn-link" disabled id="Negativo{{$question->id}}" title='Ya has votado negativamente por esta pregunta'>
                            <i class="fa fa-chevron-down"> </i>
                        </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="m-b-md">
                        <div class="pull-right">
                            <a href="/forums/show/{{$record->name}}" class="btn btn-white btn-xs"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        </div>
                        <h2>{{$question->name}}</h2>
                    </div>
                    @if($question->created_at->diffInMinutes() < 5)
                    <dl class="dl-horizontal">
                        <span class="label label-primary pull-right">Nueva</span>
                    </dl>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1">
                </div>
                <div class="col-lg-7">
                    <h4><p>{!! $question->body !!}</p></h4>
                </div>
                <div class="col-lg-4">
                    <div class="pull-right">
                        <dl class="dl-horizontal">
                            <dt>Creado por:</dt> <dd>{{$question->user->name}}</dd>
                            <dt>Creada:</dt> <dd>{{$question->created_at->diffForHumans()}}</dd>
                            <dd><div class="social-avatar">
                                <a href=""><img alt="image" src="{{ asset('uploads/avatars/'. $question->user->avatar) }}"></a>
                            </div></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="panel blank-panel">
                <div class="panel-body">
                    <div class="social-feed-separated">
                        @foreach ($comments as $conversations)
                                
                            @if (count($conversations['Answer'][0]) > 0)
                            @foreach ($conversations['Answer'][0] as $itemConversation)
                                <div class="social-avatar">
                                    <a href=""><img alt="image" src="{{ asset('uploads/avatars/'. $itemConversation->user->avatar) }}"></a>
                                </div>
                                <div class="social-feed-box">
                                    <div class="social-avatar">
                                        <a href="#">{{ $itemConversation->user->name }}</a><small class="text-muted"> - {{ $itemConversation->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="social-body">
                                        <p>{{ $itemConversation->name }}</p><br>
                                        <div class="btn-group">
                                            <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $itemConversation->id }})"><i class="fa fa-comments"></i> Responder</a>
                                        </div>
                                    </div>
                                    <div class="social-footer">

                                        @if (count($itemConversation['AnswerToAnswer']) > 0)
                                        @foreach ($itemConversation['AnswerToAnswer'] as $itemAnswer)
                                            <div class="social-comment">
                                                <a href="" class="pull-left"><img alt="image" src="{{ asset('uploads/avatars/'. $itemAnswer->user->avatar) }}"></a>
                                                <div class="media-body">
                                                    <a href="#">{{ $itemAnswer->user->name }}</a>  {{ $itemAnswer->name }}<br> - <small class="text-muted">{{ $itemAnswer->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif

                                        <div class="social-comment hidden" id="comentario{{ $itemConversation->id }}">
                                            <a href="" class="pull-left"><img alt="image" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
                                            <div class="media-body">
                                                <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer to Answer', {{ $itemConversation->id }})" placeholder="Escribe una respuesta..."></textarea>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <div class="hr-line-dashed"></div>
                                @endif
                                @endforeach
                                @endif
                            
                            <div id='ultimo_comentario' class="hr-line-dashed"></div>
                            <div class="social-avatar">
                                <a href=""><img alt="image" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
                            </div>
                            <div class="social-feed-box">
                                <div class="social-footer">
                                    <div class="media-body">
                                    <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer', {{ $conversations['Question']->id }})" placeholder="Redacta una respuesta..."></textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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

    function vote(option, questionId) {
        idRecord = $('#idRecord').val();
        $.ajax({
            url: "/votes/store",
            data: { 
                "option":option,
                "id_record":idRecord,
                "questionId":questionId,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                $('#'+option+questionId).prop('disabled', true);
                if(option === 'Positivo') {
                    $('#'+option+questionId).prop('title', 'Ya has votado positivamente por esta pregunta');
                    $('#Negativo'+questionId).prop('disabled', false);
                    if(result.answer === 'updated') {
                        $('#Negativo'+questionId).prop('title', 'Esta pregunta no es útil');
                    }
                } else {
                    $('#'+option+questionId).prop('title', 'Ya has votado negativamente por esta pregunta');
                    $('#Positivo'+questionId).prop('disabled', false);
                    if(result.answer === 'updated') {
                        $('#Positivo'+questionId).prop('title', 'Esta pregunta es útil');
                    }
                }
                $('#votes'+questionId).html(result.votes);
            },
            error: function () {
               //alert("fallo");
            }
            
        });
    }
    
    function pulsar(textarea, e, tipoComentario, idParent) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            comentario = $(textarea).val();
            if (comentario !== '') {
                $(textarea).val('');
                agregarComentario('forums', comentario, tipoComentario, idParent);
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
                if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="hr-line-dashed"></div><div class="social-avatar"><a href=""><img alt="image" src="'+imagenUsuario+'"></a></div>\n\
                    <div class="social-feed-box"><div class="social-avatar"><a href="#">'+result.user_name+'</a><small class="text-muted"> - '+result.tiempo+'</small></div>\n\
                    <div class="social-body"><p>'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div></div>';
                    $('#ultimo_comentario').before(html);
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