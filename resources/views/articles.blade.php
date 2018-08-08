@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Artículos</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Artículos de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Artículos de la organización
            </li>
                <li class="active">
                @if($record->exists)
                    <strong>Editar artículo</strong>
                @else
                    <strong>Crear artículo</strong>
                @endif
                </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form' AND Auth::check())
        <div class="title-action">
            <a href="/articles/create" class="btn btn-primary btn-sm">Agregar Artículo</a>
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
                <h5>Registra la información <small>Artículo.</small></h5>
                <div class="ibox-tools">
                    <a href="/articles">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                @if($record->exists)
                <form method="post" action="/articles/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/articles/store" id="form-create" class="form-horizontal">
                @endif
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre del artículo</label>
                        <div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{ $record->name or old('name') }}" required></div>
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
                    <input type="hidden" id="contenido" name="contenido">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Contenido</label>
                        <div class="col-sm-10"><textarea id="editor" class="form-control" required>{!! $record->contenido or old('contenido') !!}</textarea> </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('editor');
        CKEDITOR.instances.editor.on("change", function() {
            $('#contenido').val(CKEDITOR.instances.editor.getData());
        });
    });
    
</script>
@elseif($typeView == 'list')

<div class="wrapper wrapper-content animated fadeInRight">
    @if (count($records) !== 0)
        <div class="grid">
            @foreach ($records as $rec)
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-title">
                        @if($rec->created_at->diffInMinutes() < 2)
                            <span class="label label-primary pull-right">Nuevo</span>
                        @endif
                        <h5 class="cortar"><a href="/articles/show/{{ $rec->id }}" > {{ $rec->name }} </a></h5>
                    </div>
                    <div class="ibox-content">
                        @include('layouts._spinner_code')
                        <div class="row  m-t-sm">
                            <div class="col-sm-6">
                                <div class="font-bold">Creado por:</div>{{ $rec->user->name }}
                            </div>
                            <div class="col-sm-6">
                                <div class="font-bold">Modulo:</div>{{ $rec->module->name }}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h4>Contenido:</h4>
                        <div class="cortar_largo">
                            <p>
                            {!! $rec->contenido !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de artículos</h5>
                    </div>
                    <div class="ibox-content">
                        @include('layouts._spinner_code')

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>Nombre del artículo</th>
                                        <th>Fecha de creación</th>
                                        <th>Creado por</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($records as $rec)

                                    <tr class="gradeX">
                                        <td>{{ $rec->name }}</td>
                                        <td>{{ $rec->created_at }}</td>
                                        <td>{{ $rec->user->name }}</td>
                                    </tr>

                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>Nombre del artículo</th>
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
    @endif
</div>

@elseif($typeView == 'view')
<input type="hidden" id="idRecord" value="{{ $record->id }}">
<div class="wrapper wrapper-content  animated fadeInRight article">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content">
                    <input id="nameUserGuest" type="hidden" value="">
                    @include('layouts._spinner_code')
                    @if (Auth::check())
                        <div class="pull-right">
                            <a href="/articles/edit/{{ $record->id }}" class="btn btn-white btn-xs"> <i class="fa fa-pencil"></i> Editar</a>
                            <a href="/articles" class="btn btn-white btn-xs"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        </div>
                    @endif
                    <div class="text-center article-title">
                        <span class="text-muted"><i class="fa fa-clock-o"></i> {{ $record->created_at->diffForHumans() }}</span>
                        <h1>{{$record->name}}</h1>
                    </div>
                    {!! $record->contenido !!}
                    <br>
                    <a class="btn btn-white btn-xs space-button-left" onclick='habilitarComentario("_ultimo")'><i class="fa fa-comments"></i> Comentar</a>
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Comentarios:</h3>
                                <div class="social-feed-separated">
                                    @foreach ($comments as $conversations)
                                    <div class="social-avatar item-{{ $conversations['Question']->id }}">
                                        <a><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $conversations['Question']->user->avatar) }}"></a>
                                    </div>
                                    <div class="social-feed-box item-{{ $conversations['Question']->id }}">
                                        <div class="social-avatar">
                                            <a href="/profile/user/{{ $conversations['Question']->user->id }}">{{ $conversations['Question']->user->name }}</a><small class="text-muted" id="time-{{ $conversations['Question']->id }}"> - {{ $conversations['Question']->updated_at->diffForHumans() }}</small>
                                            @if (Auth::check())
                                                @if ($conversations['Question']->user->id === Auth::user()->id AND $conversations['Question']->name !== 'Este comentario se ha eliminado')
                                                    <button type="button" id="delete-{{ $conversations['Question']->id }}" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="{{ $conversations['Question']->id }}" data-typeconversation="Question" title="Eliminar comentario">×</button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="social-body">
                                            @if ($conversations['Question']->name !== 'Este comentario se ha eliminado')
                                                <p id="item-{{ $conversations['Question']->id }}">{{ $conversations['Question']->name }}</p><br>
                                            @else
                                                <p id="item-{{ $conversations['Question']->id }}" class="font-italic">{{ $conversations['Question']->name }}</p><br>
                                            @endif
                                            <div class="btn-group">
                                                <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $conversations['Question']->id }})"><i class="fa fa-comments"></i> Comentar</a>
                                            </div>
                                        </div>
                                        <div class="social-footer">
                                            @if (count($conversations['Answer'][0]) > 0)
                                            @foreach ($conversations['Answer'][0] as $itemConversation)
                                            <div class="social-comment item-{{ $itemConversation->id }}">
                                                <a class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $itemConversation->user->avatar) }}"></a>
                                                <div class="media-body">
                                                    <a href="/profile/user/{{ $itemConversation->user->id }}">{{ $itemConversation->user->name }}</a> - <small class="text-muted" id="time-{{ $itemConversation->id }}">{{ $itemConversation->updated_at->diffForHumans() }}</small>
                                                    @if (Auth::check())
                                                        @if ($itemConversation->user->id === Auth::user()->id AND $itemConversation->name !== 'Este comentario se ha eliminado')
                                                            <button type="button" id="delete-{{ $itemConversation->id }}" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="{{ $itemConversation->id }}" data-typeconversation="AnswerWall" title="Eliminar comentario">×</button>
                                                        @endif
                                                    @endif
                                                    @if ($itemConversation->name !== 'Este comentario se ha eliminado')
                                                        <div id="item-{{ $itemConversation->id }}">{{ $itemConversation->name }}</div>
                                                    @else
                                                        <div id="item-{{ $itemConversation->id }}" class="font-italic">{{ $itemConversation->name }}</div>
                                                    @endif
                                                    <div class="btn-group">
                                                        <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $itemConversation->id }})"><i class="fa fa-comments"></i> Comentar</a>
                                                    </div>
                                                </div>

                                                @if (count($itemConversation['AnswerToAnswer']) > 0)
                                                @foreach ($itemConversation['AnswerToAnswer'] as $itemAnswer)
                                                <div class="social-comment item-{{ $itemAnswer->id }}">
                                                    <a class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $itemAnswer->user->avatar) }}"></a>
                                                    @if (Auth::check())
                                                        @if ($itemAnswer->user->id === Auth::user()->id AND $itemAnswer->name !== 'Este comentario se ha eliminado')
                                                            <button type="button" id="delete-{{ $itemAnswer->id }}" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="{{ $itemAnswer->id }}" data-typeconversation="AnswerTo" title="Eliminar comentario">×</button>
                                                        @endif
                                                    @endif
                                                    <div class="media-body">
                                                        <a href="/profile/user/{{ $itemAnswer->user->id }}">{{ $itemAnswer->user->name }}</a> - <small class="text-muted" id="time-{{ $itemAnswer->id }}">{{ $itemAnswer->updated_at->diffForHumans() }}</small>
                                                        <div>{{ $itemAnswer->name }}</div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif

                                                <div class="social-comment hidden" id="comentario{{ $itemConversation->id }}">
                                                    @if (Auth::check())
                                                        <a class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                                                    @else
                                                        <a class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/default.jpg') }}"> </a>
                                                    @endif
                                                    <div class="media-body">
                                                        <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer to Answer', {{ $itemConversation->id }})" placeholder="Escribe un comentario..."></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            @endforeach
                                            @endif
                                            <div class="social-comment hidden" id="comentario{{ $conversations['Question']->id }}">
                                                @if (Auth::check())
                                                    <a class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                                                @else
                                                    <a class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/default.jpg') }}"> </a>
                                                @endif
                                                <div class="media-body">
                                                    <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer', {{ $conversations['Question']->id }})" placeholder="Escribe un comentario..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed item-{{ $conversations['Question']->id }}"></div>

                                    @endforeach 

                                    <div id='comentario_ultimo' class="hidden">
                                        <div class="social-avatar">
                                            @if (Auth::check())
                                                <a class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                                            @else
                                                <a class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/default.jpg') }}"> </a>
                                            @endif
                                        </div>
                                        <div class="media-body">
                                            <textarea class="form-control" onkeypress="pulsar(this, event, 'Question', null)" placeholder="Escribe un comentario..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="confirmDeleteConversation" tabindex="-1" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Confirmar</h4>
                                            </div>
                                            <div class="modal-body">
                                                <h3 class="text-center">¿Esta seguro que desea eliminar el comentario?</h3>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="buttonConfirmDelete" onclick="" class="btn btn-primary primary">Aceptar</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="guestDataUser" tabindex="-1" role="dialog" data-typeconversation="" data-idcampo="">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Ingrese sus datos</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <div class="form-group">
                                                            <label>Nombre:</label>
                                                            <input type="text" id="nameGuest" class="form-control" maxlength="200" required>
                                                            <span id="nameguest-error" class="hidden span-error">Por favor coloque su nombre.</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Correo:</label>
                                                            <input type="email" id="emailGuest" class="form-control" maxlength="200" required>
                                                            <span id="emailguest-error" class="hidden span-error">Por favor coloque su correo.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h5 class="text-right font-italic">*Su dirección de correo no será publicada.</h5>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="confirmUserData" onclick="" class="btn btn-primary primary">Aceptar</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
@include('layouts._script_comentarios_guest')
@endif

<script>
    function pulsar(textarea, e, tipoComentario, idParent) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            comentario = $(textarea).val();
            if (comentario !== '') {
                $(textarea).val('');
                agregarComentario('articles', comentario, tipoComentario, idParent);
            }
        }
    }
</script>
@include('layouts._script_spinner_code')
@endsection