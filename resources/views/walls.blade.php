@extends('layouts.app')

@section('content')
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
            @elseif($typeView == 'view')
            <li>
                Muro de la organización
            </li>
            <li class="active">
                <strong>Muro del modulo {{ $record->module->name }}</strong>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Ruta</th>
                                    <th>Descripción</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td>{{ asset('/walls/show/'.$rec->name) }}</td>
                                    <td>{{ $rec->description }}</td>
                                    <td>{{ $rec->created_at }}</td>
                                    <td>{{ $rec->user->name }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
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
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row m-t-sm">
                <div class="col-lg-12">
                    <!-- <form class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" id="contenido" name="contenido">
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Publicar</label>
                            <div class="col-sm-11"><textarea id="editor" class="form-control" required></textarea> </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-2">
                                <input type="button" class="btn btn-primary btn-sm" onclick="" value="Publicar">
                            </div>
                            <div class="col-sm-5">
                            </div>
                        </div>
                        <br>
                    </form> -->
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div data-sample="1" id="publicacion"></div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5"></div>
                            <div class="col-sm-2">
                                <input id="toggle" class="btn btn-primary btn-sm" value="Nueva publicación">
                                <input id="reset" style="display:none" class="btn btn-warning btn-sm" value="Reestablecer">
                            </div>
                            <div class="col-sm-5"></div>
                        </div>
                    </form>
                    <br>
                    <div class="panel blank-panel">
                        <div class="panel-body">
                            <div class="social-feed-separated">
                                <input type="hidden" id="firstPost">
                                @foreach ($comments as $conversations)
                                @php
                                    $id = $conversations['Question']->name;
                                    $post = $record->posts->firstWhere('id', $id);
                                @endphp
                                <div class="social-avatar">
                                    <a href=""><img alt="image" src="{{ asset('uploads/avatars/'. $conversations['Question']->user->avatar) }}"></a>
                                </div>
                                <div class="social-feed-box">
                                    <div class="social-avatar">
                                        <a href="#">{{ $post->user->name }}</a><small class="text-muted"> - {{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="social-body">
                                        {!! $post->body !!}<br>
                                        <div class="btn-group">
                                            @if($post->likes->count() > 0)
                                                @if($post->likes->firstWhere('created_by', Auth::user()->id) !== null)
                                                    <a class="btn btn-white btn-xs" id="prueba" onclick="likeDislike(this, {{ $post->id }})"><i class="fa fa-thumbs-up"></i> <span>{{ $post->likes->count() }} Ya no me gusta</span></a>
                                                @else
                                                    <a class="btn btn-white btn-xs" onclick="likeDislike(this, {{ $post->id }})"><i class="fa fa-thumbs-up"></i> <span>{{ $post->likes->count() }} Me gusta</span></a>
                                                @endif
                                            @else
                                                <a class="btn btn-white btn-xs" onclick="likeDislike(this, {{ $post->id }})"><i class="fa fa-thumbs-up"></i> <span>Me gusta</span></a>
                                            @endif
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
                                                    <a class="btn btn-white btn-xs" onclick="habilitarComentario({{ $itemConversation->id }})"><i class="fa fa-comments"></i> Responder</a> - <small class="text-muted">{{ $itemConversation->created_at->diffForHumans() }}</small>
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
                                                    <textarea class="form-control" onkeypress="pulsar(this, event, 'Answer to Answer', {{ $itemConversation->id }})" placeholder="Escribe una respuesta..."></textarea>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script type="template" data-sample="1">
	&lt;script&gt;
		// The inline editor should be enabled on an element with "contenteditable" attribute set to "true".
		// Otherwise CKEditor will start in read-only mode.
		var publicacion = document.getElementById( 'publicacion' );
		publicacion.setAttribute( 'contenteditable', true );

		CKEDITOR.inline( 'publicacion', {
			// Allow some non-standard markup that we used in the publicacion.
			extraAllowedContent: 'a(documentation);abbr[title];code',
			removePlugins: 'stylescombo',
			// Show toolbar on startup (optional).
			startupFocus: true
		} );
	&lt;/script&gt;
</script>
<script>
	// Sample: Inline Editing Enabled by Code
	(function () {
		var isEditingEnabled,
				toggle = document.getElementById( 'toggle' ),
				reset = document.getElementById( 'reset' ),
				publicacion = document.getElementById( 'publicacion' ),
				publicacionHTML = publicacion.innerHTML;

		function enableEditing() {
			if ( !CKEDITOR.instances.publicacion ) {
				CKEDITOR.inline( 'publicacion', {
					extraAllowedContent: 'a(documentation);abbr[title];code',
					removePlugins: 'stylescombo',
					startupFocus: true
				} );
			}
		}

		function disableEditing() {
			if ( CKEDITOR.instances.publicacion )
				CKEDITOR.instances.publicacion.destroy();
		}

		function toggleEditor() {
			if ( isEditingEnabled ) {
				/*if ( CKEDITOR.instances.introduction && CKEDITOR.instances.introduction.checkDirty() ) {
					reset.style.display = 'inline';
				}*/
                savePost();
				disableEditing();
				publicacion.setAttribute( 'contenteditable', false );
				this.value = 'Nueva publicación';
				isEditingEnabled = false;
			}
			else {
				publicacion.setAttribute( 'contenteditable', true );
				enableEditing();
				this.value = 'Publicar';
				isEditingEnabled = true;
			}
		}

        function savePost() {
            if (publicacion.innerHTML !== '<p><br></p>') {
                post = publicacion.innerHTML;
                publicacion.innerHTML = '';
                idRecord = $('#idRecord').val();
                var imagenUsuario = '';
                imagenUsuario = '{{ asset("uploads/avatars/". Auth::user()->avatar) }}';
                $.ajax({
                    url: "/post/store",
                    data: { 
                        "table":'walls',
                        "id_record":idRecord,
                        "comentario":post,
                        "type":'Question',
                        "parent":null,
                        "_token": "{{ csrf_token() }}"
                        },
                    dataType: "json",
                    method: "POST",
                    success: function(result)
                    {
                        var answer = "\'Answer\'";
                        var html = '<div class="social-avatar"><a href=""><img alt="image" src="'+imagenUsuario+'"></a></div>\n\
                        <div class="social-feed-box"><div class="social-avatar"><a href="#">'+result.user_name+'</a><small class="text-muted"> - '+result.tiempo+'</small></div>\n\
                        <div class="social-body">'+result.body+'<br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="likeDislike(this, '+result.id+')"><i class="fa fa-thumbs-up"></i> <span>Me gusta</span></a><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a>\n\
                        <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div></div>';
                        $('#firstPost').after(html);
                    },
                    error: function () {
                    //alert("fallo");
                    }
                    
                });
            }
        }

		function resetContent() {
			reset.style.display = 'none';
			publicacion.innerHTML = publicacionHTML;
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
		onClick( reset, resetContent );

	})();
</script>
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
                agregarComentario('walls', comentario, tipoComentario, idParent);
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

    function likeDislike(element, idPost) {
        //$(element).children('span').text(' 2 Ya no me gusta');
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
@endsection