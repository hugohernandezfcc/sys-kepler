@extends('layouts.app')

@section('content')
@if($typeView != 'view')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-7">
        <h2>Muro</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView == 'list')
            <li class="active">
                <strong>Muro de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Muro de la organización
            </li>
            <li class="active">
                @if($record->exists)
                    <strong>Editar muro</strong>
                @else
                    <strong>Crear muro</strong>
                @endif
            </li>
            @elseif($typeView == 'detail')
            <li>
                Muro de la organización
            </li>
            <li class="active">
                <strong>Usuarios con acceso al muro</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-5">
        @if($typeView == 'list')
        <div class="title-action">
            <a href="/walls/create" class="btn btn-primary btn-sm">Agregar muro</a>
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
                <h5>Registra la información <small>Muro.</small></h5>
                <div class="ibox-tools">
                    <a href="/walls">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                @if($record->exists)
                <form method="post" action="/walls/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/walls/store" id="form-create" class="form-horizontal">
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
                    <h5>Lista de muros</h5>
                </div>
                <div class="ibox-content">
                    @include('layouts._spinner_code')

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
                                        <a href="/walls/{{$rec->name}}/detail" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> 
                                    </td>
                                    <td>{{ asset('/walls/show/'.$rec->name) }}</td>
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
<input type="hidden" id="idRecord" value="{{ $record->id }}">
    @if(!$agent->isMobile() || !$agent->isTablet())
    <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
    @endif
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <input id="nameUserGuest" type="hidden" value="">
                    @include('layouts._spinner_code')      
                    <div class="ibox-tools">
                        <div class="pull-right">
                            <a onClick="nuevaPublicacion()" id="toggle" data-toggle="modal" class="btn btn-primary btn-xs">Nueva publicación</a>
                        </div>
                    </div>
                    <div class="modal fade" id="redactarPublicacion">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Publicación</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="social-avatar inline">
                                    @if (Auth::check())
                                        <a><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"></a>
                                    @else
                                        <a><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/default.jpg') }}"></a>
                                    @endif
                                    </div>
                                    <div data-sample="1" id="publicacion" class="well inline" style="width: 80%"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onClick="savePost()" data-dismiss="modal">Publicar</button>
                                    <button type="button" class="btn btn-default" id="cerrarPost" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <br>
                    <div class="panel blank-panel">
                        <div class="panel-body">
                            <div class="social-feed-separated">
                                <div class="hr-line-dashed"></div>
                                <input type="hidden" id="firstPost">
                                @foreach ($comments as $conversations)
                                    @php
                                        $id = $conversations['Question']->name;
                                        $post = $record->posts->firstWhere('id', $id);
                                    @endphp
                                    <div class="social-avatar item-{{ $conversations['Question']->id }}">
                                        <a href=""><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $conversations['Question']->user->avatar) }}"></a>
                                    </div>
                                    <div class="social-feed-box item-{{ $conversations['Question']->id }}">
                                        <div class="social-avatar">
                                            <a href="/profile/user/{{ $post->user->id }}">{{ $post->user->name }}</a><small class="text-muted" id="time-{{ $conversations['Question']->id }}"> - {{ $post->updated_at->diffForHumans() }}</small>
                                            @if (Auth::check())
                                                @if ($conversations['Question']->user->id === Auth::user()->id AND $post->body !== 'Esta publicación se ha eliminado')
                                                    <button type="button" id="delete-{{ $conversations['Question']->id }}" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="{{ $conversations['Question']->id }}" data-typeconversation="QuestionWall" title="Eliminar publicación">×</button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="social-body">
                                            <br>
                                            @if ($post->body !== 'Esta publicación se ha eliminado')
                                                <div id="item-{{ $conversations['Question']->id }}">{!! $post->body !!}</div><br>
                                            @else
                                                <div id="item-{{ $conversations['Question']->id }}" class="font-italic">{{ $post->body }}</div><br>
                                            @endif
                                            <div class="btn-group">
                                                @if($post->likes->count() > 0)
                                                    @if (Auth::check())
                                                        @if($post->likes->firstWhere('created_by', Auth::user()->id) !== null)
                                                            <a class="btn btn-white btn-xs" onclick="likeDislike(this, {{ $post->id }})"><i class="fa fa-thumbs-up"></i> <span>{{ $post->likes->count() }} Ya no me gusta</span></a>
                                                        @else
                                                            <a class="btn btn-white btn-xs" onclick="likeDislike(this, {{ $post->id }})"><i class="fa fa-thumbs-up"></i> <span>{{ $post->likes->count() }} Me gusta</span></a>
                                                        @endif
                                                    @else
                                                        <a class="btn btn-white btn-xs"><i class="fa fa-thumbs-up"></i> <span>{{ $post->likes->count() }} Me gusta</span></a>
                                                    @endif
                                                @else
                                                    <a class="btn btn-white btn-xs" onclick="likeDislike(this, {{ $post->id }})"><i class="fa fa-thumbs-up"></i> <span>Me gusta</span></a>
                                                @endif
                                                <a class="btn btn-white btn-xs space-button-left" onclick="habilitarComentario({{ $conversations['Question']->id }})"><i class="fa fa-comments"></i> Comentar</a>
                                            </div>
                                        </div>
                                        <div class="social-footer">
                                            @if (count($conversations['Answer'][0]) > 0)
                                            @foreach ($conversations['Answer'][0] as $itemConversation)
                                            <div class="social-comment item-{{ $itemConversation->id }}">
                                                <a class="pull-left"><img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. $itemConversation->user->avatar) }}"></a>
                                                <div class="media-body">
                                                    <a href="/profile/user/{{ $itemConversation->user->id }}">{{ $itemConversation->user->name }}</a><small class="text-muted" id="time-{{ $itemConversation->id }}"> - {{ $itemConversation->updated_at->diffForHumans() }}</small>
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
                                                    <a href="" class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                                                @else
                                                    <a href="" class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/default.jpg') }}"> </a>
                                                @endif
                                                    <div class="media-body">
                                                        <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer to Answer', {{ $itemConversation->id }})" placeholder="Escribe una respuesta..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                            <div class="social-comment hidden" id="comentario{{ $conversations['Question']->id }}">
                                                @if (Auth::check())
                                                    <a href="" class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}"> </a>
                                                @else
                                                    <a href="" class="pull-left"> <img alt="image" class="img-circle" src="{{ asset('uploads/avatars/default.jpg') }}"> </a>
                                                @endif
                                                <div class="media-body">
                                                    <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer', {{ $conversations['Question']->id }})" placeholder="Escribe un comentario..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed item-{{ $conversations['Question']->id }}"></div>
                                @endforeach
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
    @if(!$agent->isMobile() || !$agent->isTablet())
        </div>
    </div>
    @endif
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script>
    $('#guestDataUser').on('show.bs.modal', function (event) {
        var idCampo = $('#guestDataUser').data('idcampo');
        var typeConversation = $('#guestDataUser').data('typeconversation');
        $("#confirmUserData").removeAttr('onclick');
        $('#confirmUserData').attr('onClick', 'registerGuest("'+ typeConversation +'", "'+ idCampo +'");');
    });

    $("#guestDataUser").on('hidden.bs.modal', function () {
        $('#nameguest-error').addClass('hidden');
        $('#emailguest-error').addClass('hidden');
        $('#nameGuest').val('');
        $('#emailGuest').val('');
    });

	(function () {
		var isEditingEnabled,
            toggle = document.getElementById( 'toggle' ),
            publicacion = document.getElementById( 'publicacion' ),
            publicacionHTML = publicacion.innerHTML;

		function enableEditing() {
			if ( !CKEDITOR.instances.publicacion ) {
				CKEDITOR.inline( 'publicacion', {
					extraAllowedContent: 'a(documentation);abbr[title];code',
					startupFocus: true,
                    toolbarGroups: [
                        {"name":"basicstyles","groups":["basicstyles"]},
                        {"name":"paragraph","groups":["list"]},
                        {"name":"insert","groups":["insert"]}
                    ],
                    removeButtons: 'Subscript,Superscript,Anchor,Styles,Table,HorizontalRule,SpecialChar'
				} );
			}
		}

		function toggleEditor() {
			if ( !isEditingEnabled ) {
				publicacion.setAttribute( 'contenteditable', true );
				enableEditing();
				isEditingEnabled = true;
			}
		}

		function onClick( element, callback ) {
			if ( window.addEventListener ) {
				element.addEventListener( 'click', callback, false );
			}
			else if ( window.attachEvent ) {
				element.attachEvent( 'onclick', callback );
			}
		}

		onClick( toggle, toggleEditor );

	})();

    $('#deleteWall').click(function(){
        $('#form-delete').submit();
    });

    $('#cerrarPost').click(function(){
        publicacion.innerHTML = '';
    });

    function nuevaPublicacion() {
        @if(Auth::check())
            $('#redactarPublicacion').modal('show');
        @else
            if ($('#nameUserGuest').val() !== '') {
                $('#redactarPublicacion').modal('show');
            } else {
                $('#guestDataUser').data('typeconversation', 'post');
                $('#guestDataUser').data('idcampo', '');
                $('#guestDataUser').modal('show');
            }
        @endif
    }

    function savePost() {
        if (publicacion.innerHTML !== '<p><br></p>') {
            var post = publicacion.innerHTML;
            publicacion.innerHTML = '';
            var idRecord = $('#idRecord').val();
            var imagenUsuario = '';
            @if(Auth::check())    
                imagenUsuario = '{{ asset("uploads/avatars/". Auth::user()->avatar) }}';
                var url = "/post/store";
                var user = new Object();
            @else
                imagenUsuario = '{{ asset("uploads/avatars/default.jpg") }}';
                var url = "/post/storeGuest";
                var user = $('#nameUserGuest').data('user');
            @endif
                $.ajax({
                    url: url,
                    data: { 
                        "table":'walls',
                        "id_record":idRecord,
                        "comentario":post,
                        "user":user,
                        "type":'Question',
                        "parent":null,
                        "_token": "{{ csrf_token() }}"
                        },
                    dataType: "json",
                    method: "POST",
                    success: function(result)
                    {
                        var answer = "\'Answer\'";
                        var html = '<div class="social-avatar item-'+result.item+'"><a href="#"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a></div>\n\
                        <div class="social-feed-box item-'+result.item+'"><div class="social-avatar"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.item+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.item+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="'+result.item+'" data-typeConversation="QuestionWall" title="Eliminar publicación">×</button></div>\n\
                        <div class="social-body"><div id="item-'+result.item+'">'+result.body+'</div><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="likeDislike(this, '+result.item+')"><i class="fa fa-thumbs-up"></i> <span>Me gusta</span></a><a class="btn btn-white btn-xs space-button-left" onclick="habilitarComentario('+result.item+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.item+'"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a>\n\
                        <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.item+')" placeholder="Escribe un comentario..."></textarea></div></div></div></div><div class="hr-line-dashed item-'+result.item+'"></div>';
                        $('#firstPost').after(html);
                    },
                    error: function () {
                    //alert("fallo");
                    }
                });
        }
    }

    $('#confirmDeleteConversation').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var conversationId = button.data('conversationid');
        var typeConversation = button.data('typeconversation');
        $("#buttonConfirmDelete").removeAttr('onclick');
        $('#buttonConfirmDelete').attr('onClick', 'deleteConversation("'+ conversationId +'", "'+ typeConversation +'");');
    });

    function deleteConversation(conversationId, typeConversation) {
        @if(Auth::check())
            var url = "/itemsconversations/destroy";
        @else
            var url = "/itemsconversations/destroyGuest";
        @endif
        $.ajax({
            url: url,
            data: {
                "itemConversationId":conversationId,
                "type":typeConversation,
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.result === 'delete') {
                    $('.item-' + result.itemConversation.id).remove();
                } else if (result.result === 'update') {
                    $('#item-' + result.itemConversation.id).css('font-style', 'italic');
                    $('#item-' + result.itemConversation.id).html(result.itemConversation.name);
                    $('#time-' + conversationId).html(' - ' + result.time);
                    $('#delete-' + conversationId).remove();
                }
                $('#confirmDeleteConversation').modal('hide'); 
            },
            error: function () {
            //alert("fallo");
            }
        });
    }
</script>
@elseif($typeView == 'detail')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de usuarios con acceso al muro</h5>
                    <form id="form-delete" method="post" action="/walls/{{ $record->id }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div class="pull-right">
                            <a href="/walls" class="btn btn-white btn-xs"> <i class="fa fa-chevron-left"></i> Regresar</a>
                            <a href="#confirmDelete" class="btn btn-default btn-xs" id="submitBtn" data-toggle="modal" data-target="#confirmDelete"> <i class="fa fa-remove"></i> Eliminar</a>
                        </div>
                    </form>
                </div>
                <div class="ibox-content">
                    @include('layouts._spinner_code')
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-detail" >
                            <thead>
                                <tr>
                                    <th> Nombre </th>
                                    <th> Correo </th>
                                    <th> Tipo de usuario </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($listUser = [])
                                @foreach ($record->module->subject->groups as $group)
                                    @foreach ($group->users as $groupUser)
                                        @if (!in_array($groupUser->id, $listUser))
                                            @php($listUser[] = $groupUser->id)
                                            <tr class="gradeX">
                                                <td>{{ $groupUser->name }}</td>
                                                <td><i class="fa fa-envelope"> </i> {{ $groupUser->email }}</td>
                                                <td>{{ $groupUser->type }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> Nombre </th>
                                    <th> Correo </th>
                                    <th> Tipo de usuario </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @include('layouts._modal_confirmation_delete', ['name' => 'muro'])
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.dataTables-detail').DataTable({
            pageLength: 10,
            responsive: true,
            scrollCollapse: true,
            language: {
                lengthMenu:   "Mostrar _MENU_ registros por página",
                zeroRecords:  "No se ha encontrado",
                info:         "Página _PAGE_ de _PAGES_",
                infoEmpty:    "Registros no disponibles",
                search:       "",
                paginate: {
                    first:      "Primero",
                    last:       "Ultimo",
                    next:       " Siguiente ",
                    previous:   " Anterior "
                },
                infoFiltered: "(filtrando de _MAX_ registros)"
            }
        });
        $('div.dataTables_filter input').addClass('slds-input');
        $('div.dataTables_filter input').attr("placeholder","Buscar usuario");
    });
</script>
@endif
<!-- Toastr -->
<script src="{{ asset('inspinia/js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
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
                agregarComentario('walls', comentario, tipoComentario, idParent);
            }
        }
    }
    
    function agregarComentario(tabla, comentario, tipoComentario, idParent) {
        idRecord = $('#idRecord').val();
        var imagenUsuario = '';
        @if(Auth::check())    
            imagenUsuario = '{{ asset("uploads/avatars/". Auth::user()->avatar) }}';
            var url = "/conversations/store";
            var user = new Object();
        @else
            imagenUsuario = '{{ asset("uploads/avatars/default.jpg") }}';
            var url = "/conversations/storeGuest";
            var user = $('#nameUserGuest').data('user');
        @endif
        $.ajax({
            url: url,
            data: { 
                "table":tabla,
                "id_record":idRecord,
                "comentario":comentario,
                "type":tipoComentario,
                "parent":idParent,
                "user":user,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.type === 'Question') {
                    var answer = "\'Answer\'";
                    var html = '<div class="social-avatar item-'+result.id+'"><a href=""><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a></div>\n\
                    <div class="social-feed-box item-'+result.id+'"><div class="social-avatar"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.id+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.id+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="'+result.id+'" data-typeconversation="Question" title="Eliminar comentario">×</button></div>\n\
                    <div class="social-body"><p id="item-'+result.id+'">'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..." maxlength="250"></textarea></div></div></div></div><div class="hr-line-dashed question-'+result.id+'"></div>';
                    $('#ultimo_comentario').before(html);
                } else if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="social-comment item-'+result.id+'"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.id+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.id+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="'+result.id+'" data-typeconversation="AnswerWall" title="Eliminar comentario">×</button>\n\
                    <div id="item-'+result.id+'">'+  result.name+'</div><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div>\n\
                    <div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"> <img alt="image" class="img-circle" src="'+imagenUsuario+'"> </a><div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..." maxlength="250"></textarea></div></div></div>';
                    $('#comentario'+result.parent).before(html);
                } else {
                    var html = '<div class="social-comment item-'+result.id+'"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="/profile/user/'+result.user_id+'">'+result.user_name+'</a><small class="text-muted" id="time-'+result.id+'"> - '+result.tiempo+'</small><button type="button" id="delete-'+result.id+'" class="deleteConversation pull-right btn-default" data-toggle="modal" data-target="#confirmDeleteConversation" data-conversationid="'+result.id+'" data-typeconversation="AnswerTo" title="Eliminar comentario">×</button>\n\
                    <div>'+  result.name+'</div></div></div>';
                    $('#comentario'+result.parent).before(html);
                }
            },
            error: function () {
               //alert("fallo");
            }
            
        });
    }
    
    function habilitarComentario(idCampo) {
        @if(Auth::check())
            if ($('#comentario'+idCampo).hasClass("hidden")) {
                $('#comentario'+idCampo).removeClass("hidden");
            }
            $('#comentario'+idCampo+' textarea').focus();
        @else
            if ($('#nameUserGuest').val() !== '') {
                if ($('#comentario'+idCampo).hasClass("hidden")) {
                    $('#comentario'+idCampo).removeClass("hidden");
                }
                $('#comentario'+idCampo+' textarea').focus();
            } else {
                $('#guestDataUser').data('typeconversation', 'comment');
                $('#guestDataUser').data('idcampo', idCampo);
                $('#guestDataUser').modal('show');
            }
        @endif
    }

    function registerGuest(typeConversation, idCampo) {
        if ($('#nameGuest').val() === '') {
            $('#nameguest-error').removeClass('hidden');
            return false;
        } else if ($('#emailGuest').val() === '') {
            $('#emailguest-error').removeClass('hidden');
            return false;
        } else {
            $('#nameguest-error').addClass('hidden');
            $('#emailguest-error').addClass('hidden');
            var name = $('#nameGuest').val();
            var email = $('#emailGuest').val();
            $.ajax({
                url: "/registerguest",
                data: { 
                    "name":name,
                    "email":email,
                    "_token": "{{ csrf_token() }}"
                    },
                dataType: "json",
                method: "POST",
                success: function(result)
                {
                    if (result.result !== 'unauthorized') {
                        $('#nameUserGuest').val(result.user.name);
                        $('#nameUserGuest').data().user = result.user;
                        $('#nameGuest').val('');
                        $('#emailGuest').val('');
                        $('#guestDataUser').modal('hide');
                        if (typeConversation === 'comment') {
                            habilitarComentario(idCampo);
                        } else if (typeConversation === 'post') {
                            setTimeout(function(){
                                $('#redactarPublicacion').modal('show');
                            }, 1500);
                        }
                        if (result.result === 'new') {
                            toastr.success('Sigue trabajando.', 'Gracias ' + name + ' tus datos, se han almacenado.');
                        }
                    } else {
                        toastr.warning('Correo registrado.', 'El correo '+ email +' ya existe, debes loguearte.');
                    }
                },
                error: function () {
                //alert("fallo");
                }
            });
        }
    }

    function likeDislike(element, idPost) {
        $.ajax({
            url: "/post/storeLike",
            data: { 
                "postId":idPost,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                $(element).children('span').text(result);
            },
            error: function () {
               //alert("fallo");
            }
            
        });

    }
</script>
@include('layouts._script_spinner_code')
@endsection